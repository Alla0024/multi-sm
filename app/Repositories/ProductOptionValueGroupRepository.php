<?php

namespace App\Repositories;

use App\Models\ProductOptionValueGroup;
use App\Repositories\BaseRepository;

class ProductOptionValueGroupRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'option_id',
        'option_value_group_id',
        'c1',
        'hash',
        'sort_order'
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
        return ProductOptionValueGroup::class;
    }
}
