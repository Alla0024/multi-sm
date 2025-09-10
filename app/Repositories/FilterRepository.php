<?php

namespace App\Repositories;

use App\Models\Filter;
use App\Repositories\BaseRepository;

class FilterRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'filter_group_id',
        'path',
        'sort_order',
        'default_viewed',
        'parent',
        'parent_id'
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
        return Filter::class;
    }
}
