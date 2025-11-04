<?php

namespace App\Repositories;

use App\Models\MunicipalityDescription;
use App\Repositories\BaseRepository;

class MunicipalityDescriptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'municipality_id',
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
        return MunicipalityDescription::class;
    }
}
