<?php

namespace App\Repositories;

use App\Models\PromoCodeDescription;
use App\Repositories\BaseRepository;

class PromoCodeDescriptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'promo_code_id',
        'language_id',
        'name',
        'image',
        'title',
        'description'
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
        return PromoCodeDescription::class;
    }
}
