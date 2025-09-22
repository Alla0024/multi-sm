<?php

namespace App\Repositories;

use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Builder;

class FillingDescriptionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title',
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
