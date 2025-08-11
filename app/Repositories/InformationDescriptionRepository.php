<?php

namespace App\Repositories;

use App\Models\InformationDescription;
use App\Repositories\BaseRepository;

class InformationDescriptionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name'
    ];

    protected $additionalFields = [
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
        return InformationDescription::class;
    }
}
