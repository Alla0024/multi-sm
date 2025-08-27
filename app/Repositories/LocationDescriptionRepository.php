<?php

namespace App\Repositories;

use App\Models\LocationDescription;
use App\Repositories\BaseRepository;

class LocationDescriptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'language_id',
        'name',
        'text',
        'case'
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
        return LocationDescription::class;
    }
}
