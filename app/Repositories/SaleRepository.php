<?php

namespace App\Repositories;

use App\Helpers\PictureHelper;
use App\Models\FirstPathQuery;
use App\Models\Sale;
use App\Models\SaleDescription;
use App\Models\SaleToStore;
use App\Repositories\BaseRepository;

class SaleRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'sort_order',
        'status',
        'hidden',
        'date_start',
        'date_end',
        'time_start',
        'time_end',
        'loop',
        'show_in_product',
        'show_in_sale',
        'show_more_sale_url',
        'default_sale_shop',
        'compare_options',
        'has_one_activator',
        'accrue',
        'icon'
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
        return Sale::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $sale = $this->model
            ->with([
                'descriptions.language:id,code',
                'seoPath:type_id,path',
                'stores:id,name',
            ])
            ->find($id, $columns);

        if (!$sale) {
            return null;
        }

        $descriptions = $sale->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'name' => $desc->name,
                    'description' => $desc->description,
                    'thumbnail' => $desc->thumbnail,
                    'image' => $desc->image,
                    'important_info' => $desc->important_info,
                    'mini_description' => $desc->mini_description,
                    'product_description' => $desc->product_description,
                    'big_banner' => $desc->big_banner,
                    'small_banner' => $desc->small_banner,
                ]
            ])
            ->toArray();

        return $sale
            ->setRelation('descriptions', $descriptions)
            ->setAttribute('path', $sale->seoPath->path ?? '')
            ->makeHidden('seoPath');
    }

    public function filterRows(array $input)
    {
        $perPage    = $input['perPage'] ?? 10;
        $languageId = $input['language_id'] ?? config('settings.locale.default_language_id');

        $query = $this->model::with([
            'seoPath',
            'descriptions' => fn($q) => $q->where('language_id', $languageId),
        ]);

        foreach (['sort_order', 'status'] as $field) {
            $query->when($input[$field] ?? null, fn($q, $value) => $q->where($field, $value));
        }

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

        $sales = $query->paginate($perPage);

        $baseUrl = rtrim(config('app.client_url'), '/');
        $sales->getCollection()->transform(function ($item) use ($baseUrl) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);
            $item->setAttribute(
                'client_url',
                $item->seoPath ? $baseUrl . '/' . ltrim($item->seoPath->path, '/') : null
            );
            return $item;
        });

        return $sales;
    }

    public function save(array $input, ?int $id = null)
    {
        $seoPath = $input['path'] ?? null;
        $stores = $input['stores'] ?? [];
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions'], $input['path'], $input['stores']);

        $saleSave = $input;

        $sale = $this->model->updateOrCreate(['id' => $id], $saleSave);

        foreach ($descriptions as $languageId => $descData) {
            SaleDescription::updateOrInsert(
                [
                    'sale_id' => (int)$sale->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        $stores && $sale->stores()->sync($stores);

        $seoPath && FirstPathQuery::updateOrCreate(
            ['type' => 'sale', 'type_id' => $sale->id],
            ['path' => $seoPath]
        );

        return $sale;
    }

    public function copy($ids): void
    {
        $sales = Sale::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($sales as $sale) {
            $newSale = $sale->replicate();
            $newSale->save();

            $stores = SaleToStore::where(['sale_id' => $sale->id])->get();

            foreach ($stores as $store) {
                $newStore = $store->toArray();
                $newStore['sale_id'] = $newSale->id;
                SaleToStore::create($newStore);
            }

            foreach ($sale->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->sale_id = $newSale->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        Sale::whereIn('id', $ids)->delete();
        SaleDescription::whereIn('sale_id', $ids)->delete();
        FirstPathQuery::where('type', 'sale')->whereIn('type_id', $ids)->delete();
    }
}

