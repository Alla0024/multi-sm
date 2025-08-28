<?php

namespace App\Repositories;

use App\Models\AttributeToCategory;
use App\Repositories\BaseRepository;

class AttributeToCategoryRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'attribute_id',
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
        return AttributeToCategory::class;
    }
}
