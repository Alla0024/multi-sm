<?php

namespace App\Repositories;

use App\Models\Information;
use App\Repositories\BaseRepository;

class InformationRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'sort_order',
        'status'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Information::class;
    }
}
