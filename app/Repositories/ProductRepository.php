<?php

namespace App\Repositories;

use App\Helpers\PictureHelper;
use App\Models\FirstPathQuery;
use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\ProductToStore;
use App\Models\SegmentToProduct;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'article',
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

    public function getDropdownItems($language_id, array $args): array
    {
        $products = $this->model
            ->with([
                'descriptions' => function ($query) use ($language_id, $args) {
                    $query->where('language_id', $language_id)->select(['product_id', 'language_id', 'name']);
                },
                'manufacturer',
                'category'
            ]);

        if (empty($args)) {
            $products = $products->limit(10);
        }

        /** @noinspection DuplicatedCode */
        if (isset($args['q'])) {
            if (is_numeric($args['q']) || preg_match('/^\s*[^,]+(\s*,\s*[^,]+)+\s*$/', $args['q'])) {
                if (is_array($args['q'])) {
                    $ids = $args['q'];
                } else {
                    $ids = explode(',', $args['q']);
                }

                $products->whereIn('id', $ids);
            } else {
                $products
                    ->whereHas('descriptions', function ($query) use ($args, $language_id) {
                        $query->where('language_id', $language_id)
                            ->searchSimilarity(['name'], $args['q']);
                    });
            }
        }

        if (isset($args['manufacturer_id']) && is_numeric($args['manufacturer_id'])) {
            $products->where('manufacturer_id', $args['manufacturer_id']);
        }

        if (isset($args['category_id']) && is_numeric($args['category_id']) && $args['category_id'] !== 'all') {
            $products->where('category_id', $args['category_id']);
        }

        $products = $products
            ->select(['id', 'manufacturer_id', 'category_id'])
            ->get();

        foreach ($products as $product) {
            $result[] = [
                'id' => $product->id,
                'text' => $product->descriptions->first()->name
            ];
        }

        return $result ?? [];
    }

    public function findFull($id, $columns = ['*'])
    {
        $product = $this->model
            ->with([
                'descriptions.language:id,code',
                'seoPath:type_id,path',
                'stores:id,name',
                'images',
                'filters',
                'productAttributes',
                'productAttributes.attribute',
                'icons',
                'optionValueGroups',
                'productOptions',
                'manufacturer',
                'category',
                'productOversizes',
                'productOptionValues',
                'productRelated',
                'videos',
                'companions',
                'similarProducts',
                'certificates',
                'filling',
                'kitProducts',
                'segments'
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

        $product_filters = $product->filters
            ->mapWithKeys(fn($filter) => [
                $filter->id => [
                    'id' => $filter->id,
                    'filter_group_id' => $filter->filter_group_id,
                    'group_name' => $filter->filterGroup->description->name ?? '',
                    'name' => $filter->description->name ?? '',
                ],
            ])
            ->toArray();

        $product_attributes = $product->productAttributes
            ->mapWithKeys(function ($productAttribute) {
                $texts = $productAttribute->descriptions->mapWithKeys(fn($desc) => [
                    $desc->language_id => [
                        'text_with_keys' => $desc->text_with_keys ?: $desc->text,
                        'text' => $desc->text,
                    ],
                ]);

                return [
                    $productAttribute->attribute_id => [
                        'text_with_keys' => $texts->map(fn($t) => $t['text_with_keys'])->toArray(),
                        'text' => $texts->map(fn($t) => $t['text'])->toArray(),
                        'mark' => $productAttribute->mark,
                        'id' => $productAttribute->attribute_id,
                        'attribute' => [
                            'name' => $productAttribute->attribute->description->name ?? '',
                        ],
                        'group' => [
                            'name' => $productAttribute->attribute->attributeGroup->description->name ?? '',
                        ],
                        'icons' => $productAttribute->attribute->icons ?? [],
                    ],
                ];
            })
            ->toArray();

        $product_icons = $product->icons
            ->groupBy('attribute_id')
            ->mapWithKeys(fn($icons, $attributeId) => [
                $attributeId => $icons->mapWithKeys(fn($icon) => [
                    $icon->icon_id => $icon->icon_id,
                ])->toArray()
            ])
            ->toArray();

        $product_options = $product->options
            ->mapWithKeys(function ($option) use ($id) {
                $comments = $option->descriptions
                    ->where('product_id', $id)
                    ->pluck('comment', 'language_id')
                    ->toArray();

                return [
                    $option->option_id => [
                        'id' => $option->option_id,
                        'name' => $option->option->description->name ?? '',
                        'c1' => $option->c1 ?? null,
                        'hide_option' => $option->hide_option ?? false,
                        'image_change' => $option->image_change ?? 0,
                        'hash' => $option->hash ?? '',
                        'comments' => $comments,
                    ],
                ];
            })
            ->toArray();

        $product_option_values = $product->productOptionValues
            ->keyBy('option_value_group_id');

        $product_option_value_groups = $product->optionValueGroups
            ->sortBy('option_value_group.sort_order')
            ->groupBy('option_id')
            ->mapWithKeys(function ($groups, $optionId) use ($product_option_values) {
                return [
                    $optionId => $groups->map(function ($group) use ($product_option_values) {
                        return [
                            'id' => $group->option_value_group_id,
                            'c1' => $group->c1,
                            'hash' => $group->hash,
                            'sort_order' => $group->sort_order,
                            'name' => $group->option_value_group->description->name ?? '',
                            'option_value' => $product_option_values[$group->option_value_group_id] ?? null,
                        ];
                    })->toArray()
                ];
            })
            ->toArray();

        $product_kits = [];

        if ($product->kit && $product->kits) {
            $product_kits = $product->kits
                ->map(function ($kit) {
                    $kitProduct = $kit->kitProduct()->with('description')->first();

                    return [
                        'product_id' => $kitProduct->id,
                        'name' => $kitProduct->description->name ?? '',
                        'sort_order' => $kit->sort_order,
                        'quantity' => $kit->quantity,
                    ];
                })
                ->toArray();
        }

        return $product
            ->setRelation('descriptions', $descriptions)
            ->setRelation('filters', $product_filters)
            ->setRelation('productAttributes', $product_attributes)
            ->setRelation('icons', $product_icons)
            ->setRelation('productOptions', $product_options)
            ->setRelation('optionValueGroups', $product_option_value_groups)
            ->setRelation('kitProducts', $product_kits)
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
            if (array_key_exists($field, $input) && $input[$field] !== '' && $input[$field] !== null) {
                $query->where($field, $input[$field]);
            }
        }

        $query->when(!empty($input['article']), function ($q) use ($input) {
            $q->where('article', 'LIKE', "%{$input['article']}%");
        });

        if (isset($input['is_vtm']) && $input['is_vtm'] !== '') {
            $query->whereHas('manufacturer', function ($sub) use ($input) {
                $sub->where('is_vtm', (int) $input['is_vtm']);
            });
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
        $segments = $input['segments'] ?? [];
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions'], $input['path'], $input['stores'], $input['segments']);

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

        $segments && $product->segments()->sync($segments);

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
            $newProduct->article = $this->generateArticleCode();
            $newProduct->status = 0;
            $newProduct->rating = 0;
            $newProduct->reviews = 0;
            $newProduct->save();

            $stores = ProductToStore::where(['product_id' => $product->id])->get();

            foreach ($stores as $store) {
                $newStore = $store->toArray();
                $newStore['product_id'] = $newProduct->id;
                ProductToStore::create($newStore);
            }

            $segments = SegmentToProduct::where(['product_id' => $product->id])->get();

            foreach ($segments as $segment){
                $newSegment = $segments->toArray();
                $newSegment['product_id'] = $newProduct->id;
                SegmentToProduct::create($newSegment);
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

    private function generateArticleCode()
    {
        $maxArticle = Product::max('article');
        return (string)($maxArticle + 1);
    }
}
