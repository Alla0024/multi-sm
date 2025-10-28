<?php

namespace App\Repositories;

use App\Models\ShopDescription;
use App\Repositories\BaseRepository;

class ShopDescriptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'name',
        'address',
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
        return ShopDescription::class;
    }
}
