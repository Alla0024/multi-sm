<?php

namespace App\Repositories;

use App\Models\AttributeIconToAttribute;
use App\Repositories\BaseRepository;

class AttributeIconToAttributeRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'attribute_id',
        'attribute_icon_id'
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
        return AttributeIconToAttribute::class;
    }
}
