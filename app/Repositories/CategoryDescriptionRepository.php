<?php

namespace App\Repositories;

use App\Models\CategoryDescription;
use App\Repositories\BaseRepository;

class CategoryDescriptionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'language_id',
        'name',
        'tag'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return CategoryDescription::class;
    }
}
