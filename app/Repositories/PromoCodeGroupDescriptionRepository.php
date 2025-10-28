<?php

namespace App\Repositories;

use App\Models\PromoCodeGroupDescription;
use App\Repositories\BaseRepository;

class PromoCodeGroupDescriptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'promo_code_group_id',
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
        return PromoCodeGroupDescription::class;
    }
}
