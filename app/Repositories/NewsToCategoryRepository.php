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
        return NewsToCategory::class;
    }
}
