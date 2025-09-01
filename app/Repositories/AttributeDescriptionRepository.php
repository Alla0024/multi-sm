<?php

namespace App\Repositories;

use App\Models\AttributeDescription;
use App\Repositories\BaseRepository;

class AttributeDescriptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'language_id',
        'name',
        'explanation'
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
        return AttributeDescription::class;
    }
}
