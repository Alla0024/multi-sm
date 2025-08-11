<?php

namespace App\Repositories;

use App\Models\OptionValueDescription;
use App\Repositories\BaseRepository;

class OptionValueDescriptionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'language_id',
        'name',
        'type_material'
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
        return OptionValueDescription::class;
    }
}
