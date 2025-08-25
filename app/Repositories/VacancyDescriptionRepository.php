<?php

namespace App\Repositories;

use App\Models\VacancyDescription;
use App\Repositories\BaseRepository;

class VacancyDescriptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'title'
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
        return VacancyDescription::class;
    }
}
