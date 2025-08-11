<?php

namespace App\Repositories;

use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Builder;

class ManufacturerDescriptionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
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
        return Manufacturer::class;
    }
}
