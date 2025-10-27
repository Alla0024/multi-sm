<?php

namespace App\Repositories;

use App\Models\ShippingMethod;

class ShippingMethodDescriptionRepository extends BaseRepository
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
        return ShippingMethod::class;
    }
}
