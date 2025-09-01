<?php

namespace App\Repositories;

use App\Models\AttributeWord;
use App\Repositories\BaseRepository;

class AttributeWordRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'sort_order',
        'key'
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
        return AttributeWord::class;
    }
}
