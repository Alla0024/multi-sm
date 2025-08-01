<?php

namespace App\Repositories;

use App\Models\NewsToCategory;
use App\Repositories\BaseRepository;

class NewsToCategoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'category_id',
        'sort_order'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return NewsToCategory::class;
    }
}
