<?php

namespace App\Repositories;

use App\Models\InformationToStore;
use App\Repositories\BaseRepository;

class InformationToStoreRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'store_id'
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
        return InformationToStore::class;
    }
}
