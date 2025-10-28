<?php

namespace App\Repositories;

use App\Models\SaleGroupDescription;
use App\Repositories\BaseRepository;

class SaleGroupDescriptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'sale_group_id',
        'language_id',
        'name'
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
        return SaleGroupDescription::class;
    }
}
