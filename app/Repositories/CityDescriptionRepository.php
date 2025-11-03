<?php

namespace App\Repositories;

use App\Models\CityDescription;
use App\Repositories\BaseRepository;

class CityDescriptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'city_id',
        'language_id',
        'name'
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
        return CityDescription::class;
    }
}
