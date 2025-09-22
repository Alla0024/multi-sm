<?php

namespace App\Repositories;

use App\Models\AttributeWordDescription;
use App\Repositories\BaseRepository;

class AttributeWordDescriptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'word',
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
        return AttributeWordDescription::class;
    }
}
