<?php

namespace App\Repositories;

use App\Models\OptionValueGroup;
use App\Models\OptionValueGroupDescription;
use App\Repositories\BaseRepository;

class OptionValueGroupRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'image',
        'sort_order'
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
        return OptionValueGroup::class;
    }

    public function upsertMany(array $input)
    {
        foreach ($input as $optionValueGroup) {
            foreach ($optionValueGroup['description'] as $languageId => $description) {
                OptionValueGroupDescription::updateOrCreate([
                    'option_value_group_id' => $optionValueGroup['id'],
                    'language_id' => $languageId
                ], $description);
            }

            unset($optionValueGroup['description']);
        }

        foreach ($input as $optionValueGroup) {
            $optionValueGroup['css_code'] = $optionValueGroup['css_code'] ?? '';
            $optionValueGroup['image'] = $optionValueGroup['image'] ?? '';

            $target = $this->model->firstOrNew(['id' => $optionValueGroup['id']]);
            $target->fill($optionValueGroup);
            $target->save();
        }
    }

}
