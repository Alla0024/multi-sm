<?php

namespace App\Repositories;

use App\Models\OptionValue;
use App\Models\OptionValueDescription;
use App\Repositories\BaseRepository;

class OptionValueRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'image',
        'sort_order',
        'level',
    ];

    protected $additionalFields = [
        'name'
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
        return OptionValue::class;
    }

    public function filterIndexPage(int $perPage, array $params, int $language_id) {
        $optionValues = $this
            ->model
            ->leftJoin((new OptionValueDescription())->getTable() . " as od", 'od.option_value_id', '=', 'option_values.id')
            ->where('od.language_id', $language_id)
            ->paginate($perPage);

        return $optionValues;
    }
}
