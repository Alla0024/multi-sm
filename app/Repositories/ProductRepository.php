<?php

namespace App\Repositories;

use App\Helpers\PictureHelper;
use App\Models\FirstPathQuery;
use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\ProductToStore;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'article',
        'hash',
        'manufacturer_id',
        'category_id',
        'stock_status_id',
        'sort_order',
        'status',
    ];

    protected array $additionalFields = [
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function getAdditionalFields(): array
    {
        return $this->additionalFields;
    }

    public function model(): string
    {
        return Product::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $product = $this->model
            ->with([
                'descriptions.language:id,code',
                'seoPath:type_id,path',
                'stores:id,name',
            ])
            ->find($id, $columns);

        if (!$product) {
            return null;
        }

        $descriptions = $product->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'name' => $desc->name,
                    'description' => $desc->description,
                    'meta_title' => $desc->meta_title,
                    'meta_description' => $desc->meta_description,
                    'damage_comment' => $desc->damage_comment,
                    'tag' => $desc->tag,
                    'type' => $desc->type,
                    'comment_to_oversize' => $desc->comment_to_oversize
                ]
            ])
            ->toArray();

        return $product
            ->setRelation('descriptions', $descriptions)
            ->setAttribute('path', $product->seoPath->path ?? '')
            ->makeHidden('seoPath');
    }

    public function filterRows(array $input)
    {
        $perPage = $input['perPage'] ?? 10;
        $languageId = $input['language_id'] ?? config('settings.locale.default_language_id');

        $query = $this->model::with([
            'seoPath',
            'manufacturer',
            'category',
            'stockStatus',
            'descriptions' => fn($q) => $q->where('language_id', $languageId),
        ]);

        foreach (['sort_order', 'status', 'manufacturer_id', 'category_id', 'stock_status_id'] as $field) {
            $query->when($input[$field] ?? null, fn($q, $value) => $q->where($field, $value));
        }

        $query->when(!empty($input['article']), function ($q) use ($input) {
            $q->where('article', 'LIKE', "%{$input['article']}%");
        });

        $query->when($input['name'] ?? null, function ($q, $name) use ($languageId) {
            $q->whereHas('descriptions', function ($sub) use ($languageId, $name) {
                $sub->where('language_id', $languageId)
                    ->where('name', 'LIKE', "%{$name}%");
            });
        });

        $query->when($input['sortBy'] ?? null, function ($q, $sortBy) use ($languageId) {
            if (in_array($sortBy, ['name_asc', 'name_desc'])) {
                $q->withAggregate(
                    ['descriptions as name' => fn($sub) => $sub->where('language_id', $languageId)],
                    'name'
                )->orderBy('name', $sortBy === 'name_asc' ? 'asc' : 'desc');
            } elseif ($sortBy === 'created_at_asc') {
                $q->orderBy('created_at', 'asc');
            } elseif ($sortBy === 'created_at_desc') {
                $q->orderBy('created_at', 'desc');
            }
        });

        $products = $query->paginate($perPage);

        $baseUrl = rtrim(config('app.client_url'), '/');
        $products->getCollection()->transform(function ($item) use ($baseUrl) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);
            $item->setAttribute(
                'client_url',
                $item->seoPath ? $baseUrl . '/' . ltrim($item->seoPath->path, '/') : null
            );
            return $item;
        });

        return $products;
    }

    public function save(array $input, ?int $id = null)
    {
        $seoPath = $input['path'] ?? null;
        $stores = $input['stores'] ?? [];
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions'], $input['path'], $input['stores']);

        $productSave = $input;

        if (!empty($input['image'])) {
            PictureHelper::rewrite(
                $input['image'],
                config('settings.images.product.width'),
                config('settings.images.product.height')
            );

            if (str_contains($input['image'], 'storage/images')) {
                $input['image'] = substr($input['image'], 15);
            }

            $productSave['image'] = $input['image'];
        }

        $product = $this->model->updateOrCreate(['id' => $id], $productSave);

        foreach ($descriptions as $languageId => $descData) {
            ProductDescription::updateOrInsert(
                [
                    'product_id' => (int)$product->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        $stores && $product->stores()->sync($stores);

        $seoPath && FirstPathQuery::updateOrCreate(
            ['type' => 'product', 'type_id' => $product->id],
            ['path' => $seoPath]
        );

        return $product;
    }

    public function copy($ids): void
    {
        $products = Product::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($products as $product) {
            $newProduct = $product->replicate();
            $newProduct->save();

            $stores = ProductToStore::where(['product_id' => $product->id])->get();

            foreach ($stores as $store) {
                $newStore = $store->toArray();
                $newStore['product_id'] = $newProduct->id;
                ProductToStore::create($newStore);
            }

            foreach ($product->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->product_id = $newProduct->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        Product::whereIn('id', $ids)->delete();
        ProductDescription::whereIn('product_id', $ids)->delete();
        FirstPathQuery::where('type', 'product')->whereIn('type_id', $ids)->delete();
    }
}
