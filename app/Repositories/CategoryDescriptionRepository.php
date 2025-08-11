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
        return CategoryDescription::class;
    }
}
