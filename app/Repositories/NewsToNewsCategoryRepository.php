<?php

namespace App\Repositories;

use App\Models\NewsToNewsCategory;
use App\Repositories\BaseRepository;

class NewsToNewsCategoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'news_id',
        'news_category_id'
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
