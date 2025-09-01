<?php

namespace App\Repositories;

use App\Models\Language;

class LanguageRepository extends BaseRepository
{
    protected array $fieldSearchable = [

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
        return Language::class;
    }
}
