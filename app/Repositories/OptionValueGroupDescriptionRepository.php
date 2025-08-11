<?php

namespace App\Repositories;

use App\Models\OptionValueGroupDescription;
use App\Repositories\BaseRepository;

class OptionValueGroupDescriptionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'language_id',
        'name',
        'meta_title'
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
        return OptionValueGroupDescription::class;
    }
}
