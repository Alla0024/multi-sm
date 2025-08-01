<?php

namespace App\Repositories;

use App\Models\FirstPathQuery;
use App\Repositories\BaseRepository;

class FirstPathQueryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'path'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return FirstPathQuery::class;
    }

    public function isThisPathExists(string $path): bool
    {
        return $this->model->where([
            ['path' , '=' , $path]
        ])->exists();
    }
}
