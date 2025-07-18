<?php

namespace App\Repositories;

use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Builder;

class ManufacturerDescriptionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
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
