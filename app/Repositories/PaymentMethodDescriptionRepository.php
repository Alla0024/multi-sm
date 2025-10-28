<?php

namespace App\Repositories;

use App\Models\PaymentMethodDescription;
use App\Repositories\BaseRepository;

class PaymentMethodDescriptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'title',
        'comment'
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
        return PaymentMethodDescription::class;
    }
}
