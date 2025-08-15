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

    private function validateHexColor($color) {
        $strippedColor = ltrim($color, '#');
        $length = strlen($strippedColor);

        if (($length === 3 || $length === 6) && ctype_xdigit($strippedColor)) {
            return '#' . $strippedColor;
        }

        return '';
    }

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

    public function upsertMany(array $input, int|null $optionId = null): void
    {
        foreach ($input as $optionValueGroup) {
            $optionValueGroup['css_code'] = is_string($optionValueGroup['css_code']) ?
                $this->validateHexColor($optionValueGroup['css_code']) :
                '';
            $optionValueGroup['image'] = $optionValueGroup['image'] ?? '';

            $target = isset($optionValueGroup['id']) ? $this->model->firstOrNew(['id' => $optionValueGroup['id']]) : new $this->model();

            if (isset($optionId)) {
                $optionValueGroup['option_id'] = $optionId;
            }

            $target->fill($optionValueGroup);
            $target->save();

            foreach ($optionValueGroup['description'] as $languageId => $description) {
                OptionValueGroupDescription::updateOrCreate([
                    'option_value_group_id' => $target->id,
                    'language_id' => $languageId
                ], $description);
            }
        }

    }

    public function deleteAllByOptionId($optionId) {
        return $this->model->where('option_id', $optionId)->delete();
    }
}
