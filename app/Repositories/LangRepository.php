<?php

namespace App\Repositories;

use App\Models\Lang;
use App\Repositories\BaseRepository;

class LangRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'code'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Lang::class;
    }
}
