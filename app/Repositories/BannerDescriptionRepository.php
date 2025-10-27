<?php

namespace App\Repositories;

use App\Models\BannerDescription;
use App\Repositories\BaseRepository;

class BannerDescriptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'title'
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
        return BannerDescription::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }
}
