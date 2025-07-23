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
}
