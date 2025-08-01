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

    public function isThisPathExists(string $path, $exclude_id = null, $item_type = null): bool
    {
        $query = $this->model->where('path', $path);

        if (isset($item_type)) {
            $query->where('type', '<>', $item_type);
        }

        if (isset($exclude_id)) {
            $query->where('type_id', '<>', $exclude_id);
        }

        return $query->exists();
    }
}
