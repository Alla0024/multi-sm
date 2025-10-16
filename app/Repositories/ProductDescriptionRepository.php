<?php

namespace App\Repositories;

use App\Models\ProductDescription;
use App\Repositories\BaseRepository;
use App\Traits\SearchableBySimilarity;

class ProductDescriptionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
    ];

    protected $additionalFields = [
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
        return ProductDescription::class;
    }
}
