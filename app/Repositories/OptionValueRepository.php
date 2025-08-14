<?php

namespace App\Repositories;

use App\Models\OptionValue;
use App\Models\OptionValueDescription;
use App\Repositories\BaseRepository;
use Illuminate\Container\Container as Application;

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
            ->when(isset($params['name']), function ($q) use ($params) {
                return $q->searchSimilarity(['od.name'], $params['name']);
            })
            ->paginate($perPage);

        return $optionValues;
    }

    public function getDetails($id)
    {
        $optionValue = $this->model
            ->with('descriptions')
            ->find($id);

        $preshaped_descriptions = $optionValue->descriptions
            ->keyBy('language_id')
            ->toArray();
        unset($optionValue->descriptions);
        $optionValue->setAttribute('descriptions', $preshaped_descriptions);

        return $optionValue;
    }

    public function upsert($input, $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions']);

        $optionValue = $this->find($id);

        $optionValue->update($input);

        $optionValue = isset($id) ? $this->model->find($id) : null;

        if (!$optionValue) {
            $optionValue = new $this->model();
        }

        $optionValue->fill($input);
        $optionValue->save();

        foreach ($descriptions as $languageId => $descData) {
            OptionValueDescription::updateOrCreate(
                [
                    'option_value_id' => $optionValue->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        return $optionValue;
    }
}
