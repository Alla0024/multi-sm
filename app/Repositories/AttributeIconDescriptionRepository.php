<?php

namespace App\Repositories;

use App\Models\AttributeIconDescription;
use App\Repositories\BaseRepository;

class AttributeIconDescriptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'language_id',
        'title',
        'description'
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
        return AttributeIconDescription::class;
    }
}
