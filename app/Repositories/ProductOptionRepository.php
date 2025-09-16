<?php

namespace App\Repositories;

use App\Models\ProductOption;
use App\Repositories\BaseRepository;

class ProductOptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'option_id',
        'c1',
        'hash',
        'image_change',
        'hide_option'
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
        return ProductOption::class;
    }
}
