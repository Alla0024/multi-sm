<?php

namespace App\Repositories;

use App\Models\AttributeIcon;
use App\Repositories\BaseRepository;

class AttributeIconRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'image',
        'pattern',
        'value'
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
        return AttributeIcon::class;
    }
}
