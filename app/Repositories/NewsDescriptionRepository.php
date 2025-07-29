<?php

namespace App\Repositories;

use App\Models\NewsDescription;
use App\Repositories\BaseRepository;

class NewsDescriptionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return NewsDescription::class;
    }
}
