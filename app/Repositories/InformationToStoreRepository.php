<?php

namespace App\Repositories;

use App\Models\InformationToStore;
use App\Repositories\BaseRepository;

class InformationToStoreRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'store_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return InformationToStore::class;
    }
}
