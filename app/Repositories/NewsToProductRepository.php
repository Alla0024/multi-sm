<?php

namespace App\Repositories;

use App\Models\NewsToProduct;
use App\Repositories\BaseRepository;

class NewsToProductRepository extends BaseRepository
{
    protected $fieldSearchable = [
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return NewsToProduct::class;
    }

    public function getProductsDropdownByNewsId($news_id, $language_id, $fields = ['*']) {
        $news_to_product = $this->model
            ->where('news_id', '=', $news_id)
            ->select($fields)
            ->with(['product' => function ($query) use ($language_id) {
                $query->select('id')->with(['descriptions' => function ($query) use ($language_id) {
                    $query->select('product_id', 'language_id', 'name')->where('language_id', $language_id);
                }]);
            }])
            ->orderBy('sort_order', 'asc')
            ->get();

        $preshaped_products = [];

        foreach ($news_to_product as $item) {
            $preshaped_products[] = [
                'id' => $item->product->id,
                'text' => $item->product->descriptions->first()->name,
                'sort_order' => $item->sort_order,
            ];
        }

        return $preshaped_products;
    }
}
