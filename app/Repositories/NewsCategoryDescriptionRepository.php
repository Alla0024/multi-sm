<?php

namespace App\Repositories;

use App\Models\NewsCategoryDescription;
use App\Repositories\BaseRepository;

class NewsCategoryDescriptionRepository extends BaseRepository
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
        return NewsCategoryDescription::class;
    }
}
