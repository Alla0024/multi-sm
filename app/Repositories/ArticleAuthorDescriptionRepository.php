<?php

namespace App\Repositories;

use App\Models\ArticleAuthorDescription;
use App\Repositories\BaseRepository;

class ArticleAuthorDescriptionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
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
        return ArticleAuthorDescription::class;
    }
}
