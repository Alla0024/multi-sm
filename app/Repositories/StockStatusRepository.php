<?php

namespace App\Repositories;

use App\Models\StockStatus;
use App\Repositories\BaseRepository;

class StockStatusRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'status'
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
        return StockStatus::class;
    }
}
