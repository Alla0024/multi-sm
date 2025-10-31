<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\ProductReview;
use App\Repositories\BaseRepository;

class ProductReviewRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'author',
        'product_id',
        'rating',
        'status',
        'type',
        'date_value',
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
        return ProductReview::class;
    }
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $productReview = $this->model
            ->with('product')
            ->find($id, $columns);

        if (!$productReview) {
            return null;
        }

        return $productReview;
    }

    public function filterRows(array $input)
    {
        $perPage    = $input['perPage'] ?? 10;

        $query = $this->model::with([
            'product',
            'productDescription',
        ])->orderBy('date_value', 'desc');

        if (!empty($input['sort']) && !empty($input['order'])) {
            $query->orderBy($input['sort'], $input['order']);
        }

        if (!empty($input['article']) && is_numeric($input['article'])) {
            $productIds = Product::where('article', 'LIKE', "{$input['article']}%")->pluck('id')->all();
            $query->whereIn('product_id', $productIds);
        }

        if (!empty($input['product_name'])) {
            $productIds = ProductDescription::where('name', 'LIKE', "{$input['product_name']}%")->pluck('product_id')->all();
            $query->whereIn('product_id', $productIds);
        }

        foreach (['status', 'type', 'order_user_id'] as $field) {
            if (array_key_exists($field, $input) && $input[$field] !== '') {
                $query->where($field, $input[$field]);
            }
        }

        $filters = [
            'name'       => 'name',
            'created_at' => 'created_at',
            'date_fake'  => 'date_value',
            'rating'     => 'rating',
            'author'     => 'author',
        ];

        foreach ($filters as $key => $column) {
            if (!empty($input[$key])) {
                $query->where($column, 'LIKE', "%{$input[$key]}%");
            }
        }

        if (!empty($input['sortBy'])) {
            match ($input['sortBy']) {
                'name_asc'        => $query->orderBy('name'),
                'name_desc'       => $query->orderBy('name', 'desc'),
                'created_at_asc'  => $query->orderBy('created_at'),
                'created_at_desc' => $query->orderBy('created_at', 'desc'),
                default           => null,
            };
        }

        $reviews = $query->paginate($perPage);

        $baseUrl = rtrim(config('app.client_url'), '/');
        $reviews->getCollection()->transform(function ($item) use ($baseUrl) {
            $item->product_name = optional($item->productDescription)->name;
            $item->client_url   = $item->product ? $baseUrl . '/' . ltrim($item->product->path, '/') : null;
            return $item;
        });

        return $reviews;
    }

    public function save(array $input, ?int $id = null)
    {
        return $this->model->updateOrCreate(['id' => $id], $input);
    }

    public function copy(array $ids): void
    {
        $productReviews = ProductReview::whereIn('id', $ids)->get();

        foreach ($productReviews as $productReview) {
            $newProductReview = $productReview->replicate();
            $newProductReview->save();
        }
    }

    public function multiDelete($ids): void
    {
        ProductReview::whereIn('id', $ids)->delete();
    }
}

