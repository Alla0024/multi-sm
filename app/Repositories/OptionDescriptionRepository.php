<?php

namespace App\Repositories;

use App\Models\OptionDescription;
use App\Repositories\BaseRepository;

class OptionDescriptionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'language_id',
        'name',
        'comment'
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
        return OptionDescription::class;
    }
}
