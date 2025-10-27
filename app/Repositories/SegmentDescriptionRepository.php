<?php

namespace App\Repositories;

use App\Models\Segment;

class SegmentDescriptionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
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
        return Segment::class;
    }
}
