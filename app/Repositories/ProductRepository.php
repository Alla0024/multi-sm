<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'article',
        'hash',
        'sku',
        'kit',
        'currency_id',
        'manufacturer_id',
        'category_id',
        'kit_id',
        'stock_status_id',
        'sort_order',
        'status',
        'rozetka_status',
        'google_remarketing_status',
        'rating',
        'reviews',
        'location_id',
        'name_in_1c',
        'copy',
        'image',
        'image_path',
        'viewers_number_from',
        'viewers_number_to',
        'show_in_stock',
        'show_count_viewers',
        'mini_images',
        'mark',
        'cashback'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
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

        if (isset($args['q'])) {
            $products
                ->whereHas('descriptions', function ($query) use ($args, $language_id) {
                    $query->where('language_id', $language_id)
                        ->searchSimilarity(['name'], $args['q']);
                });
        }

        if (isset($args['manufacturer_id']) && is_numeric($args['manufacturer_id'])) {
            $products->where('manufacturer_id', $args['manufacturer_id']);
        }

        if (isset($args['category_id']) && is_numeric($args['category_id']) && $args['category_id'] !== 'all') {
            $products->where('category_id', $args['category_id']);
        }

        if (isset($args['products_id'])) {
            if (is_array($args['products_id'])) {
                $ids = $args['products_id'];
            } else {
                $ids = explode(',', $args['products_id']);
            }

            $products->whereIn('id', $ids);
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
}
