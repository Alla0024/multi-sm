<?php

namespace App\Repositories;

use App\Models\NewsToNewsCategory;
use App\Repositories\BaseRepository;

class NewsToNewsCategoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return NewsToNewsCategory::class;
    }
}
