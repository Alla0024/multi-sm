<?php

namespace App\Repositories;

use App\Models\ArticleAuthor;
use App\Repositories\BaseRepository;

class ArticleAuthorRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'avatar',
        'date_of_birth',
        'facebook',
        'instagram'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return ArticleAuthor::class;
    }
}
