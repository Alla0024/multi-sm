<?php

namespace App\Repositories;

use App\Models\OptionValue;
use App\Repositories\BaseRepository;

class OptionValueRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'parent_id',
        'type',
        'image',
        'level',
        'sort_order',
        'status',
        'default'
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
        return OptionValue::class;
    }
}
