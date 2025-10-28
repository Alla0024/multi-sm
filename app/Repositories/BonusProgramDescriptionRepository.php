<?php

namespace App\Repositories;

use App\Models\BonusProgramDescription;
use App\Repositories\BaseRepository;

class BonusProgramDescriptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'bonus_program_id',
        'language_id',
        'name',
        'header',
        'mini_description',
        'description',
        'text'
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
        return BonusProgramDescription::class;
    }
}
