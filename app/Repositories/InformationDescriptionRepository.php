<?php

namespace App\Repositories;

use App\Models\InformationDescription;
use App\Repositories\BaseRepository;

class InformationDescriptionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return InformationDescription::class;
    }
}
