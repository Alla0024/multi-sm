<?php

namespace App\Repositories;

use App\Models\News;
use App\Repositories\BaseRepository;

class NewRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'category_id',
        'author_id',
        'thumbnail',
        'sort_order',
        'status',
        'shared_on_facebook',
        'shared_on_twitter',
        'reviews_count',
        'reviews_rating'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return News::class;
    }
}
