<?php

namespace App\Repositories;

use App\Models\FilterDescription;
use App\Repositories\BaseRepository;

class FilterDescriptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'name',
    ];

    protected array $additionalFields = [
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
        return FilterDescription::class;
    }
}
