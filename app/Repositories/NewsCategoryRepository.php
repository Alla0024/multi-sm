<?php

namespace App\Repositories;

use App\Models\NewsCategory;
use App\Repositories\BaseRepository;

class NewsCategoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'status',
        'seo_url',
        'sort_order'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return NewsCategory::class;
    }
}
