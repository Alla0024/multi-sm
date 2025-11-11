<?php

namespace App\Repositories;

use App\Models\BankProgramDescription;
use App\Repositories\BaseRepository;

class BankProgramDescriptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'title',
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
        return BankProgramDescription::class;
    }
}
