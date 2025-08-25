<?php

namespace App\Repositories;

use App\Models\Vacancy;
use App\Repositories\BaseRepository;

class VacancyRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'location_id',
        'status'
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
        return Vacancy::class;
    }
}
