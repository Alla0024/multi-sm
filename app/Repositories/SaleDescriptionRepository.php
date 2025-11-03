<?php

namespace App\Repositories;

use App\Models\SaleDescription;
use App\Repositories\BaseRepository;

class SaleDescriptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'name',
        'image',
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
        return SaleDescription::class;
    }
}
