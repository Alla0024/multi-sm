<?php

namespace App\Repositories;

use App\Models\Manufacturer;
use App\Repositories\BaseRepository;

class ManufacturerRepository extends BaseRepository
{
    protected $fieldSearchable = [
        
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Manufacturer::class;
    }
}
