<?php

namespace App\Repositories;

use App\Models\AttributeGroup;
use App\Repositories\BaseRepository;

class AttributeGroupRepository extends BaseRepository
{
    protected array $fieldSearchable = [
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
        return AttributeGroup::class;
    }
}
