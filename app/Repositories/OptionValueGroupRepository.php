<?php

namespace App\Repositories;

use App\Models\OptionValueGroup;
use App\Repositories\BaseRepository;

class OptionValueGroupRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'image',
        'sort_order'
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
        return OptionValueGroup::class;
    }
}
