<?php

namespace App\Repositories;

use App\Models\Product;
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
}
