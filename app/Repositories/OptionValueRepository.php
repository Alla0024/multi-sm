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
        'name',
        'children_status'
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

    private function updateStatusRecursive(int $parent_id, bool $status): void
    {
        $descendants = $this->model->where('parent_id', $parent_id)
            ->where('id', '<>', $parent_id)
            ->get();

        foreach ($descendants as $descendant) {
            $descendant->update(['status' => $status]);
            $this->updateStatusRecursive($descendant->id, $status);
        }
    }

    public function getBreadCrumbsRecursive($child_id, $language_id, $level = null)
    {
        $breadcrumbs = [];
        $currentLevel = $level;

        while ($child_id) {
            $optionValue = $this->model
                ->join((new OptionValueDescription())->getTable() . ' as od', 'od.option_value_id', '=', 'option_values.id')
                ->where('option_values.id', $child_id)
                ->where('od.language_id', $language_id)
                ->when($currentLevel && $currentLevel >= 0, function ($query) use ($currentLevel) {
                    $query->where('od.level', $currentLevel);
                })
                ->select('option_values.id', 'option_values.parent_id', 'od.name')
                ->first();

            if (!$optionValue || $optionValue->id == $optionValue->parent_id) break;

            $breadcrumbs[] = [
                'id' => $optionValue->id,
                'name' => $optionValue->name,
            ];

            $child_id = $optionValue->parent_id ?: null;
            $currentLevel = $currentLevel - 1;
        }

        return array_reverse($breadcrumbs);
    }

    public function filterIndexPage(int $perPage, array $params, int $language_id, int|null $id = null)
    {
        $optionValues = $this
            ->model
            ->leftJoin((new OptionValueDescription())->getTable() . " as od", 'od.option_value_id', '=', 'option_values.id')
            ->where('od.language_id', $language_id)
            ->where('parent_id', $id)
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
        $children_status = $input['children_status'] ?? 0;
        $input['level'] = 0;

        unset($input['descriptions'],$input['children_status']);

        $optionValue = $this->find($id);

        $optionValue->update($input);

        $optionValue = isset($id) ? $this->model->find($id) : null;

        if (!$optionValue) {
            $optionValue = new $this->model();
            $id = $optionValue->id;
        }

        $optionValue->fill($input);
        $optionValue->save();

        foreach ($descriptions as $languageId => $descData) {
            foreach ($descData as $key => $value) {
                if (is_null($value)) {
                    $descData[$key] = "";
                }
            }
            OptionValueDescription::updateOrCreate(
                [
                    'option_value_id' => $id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        if (isset($children_status)) {
            $this->updateStatusRecursive($id, $children_status);
        }

        return $optionValue;
    }
}
