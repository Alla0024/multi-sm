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

    public function isThisPathExists(string $path, $exclude_id): bool
    {
        return $this->model->where([
            ['id' , '<>' , $exclude_id],
            ['path' , '=' , $path]
        ])->exists();
    }
}
