<?php

namespace App\Repositories;

use App\Models\OptionValue;
use App\Models\OptionValueDescription;
use App\Repositories\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Pagination\LengthAwarePaginator;

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

    private function buildTree(array $elements): array
    {
        $map = [];
        $tree = [];

        foreach ($elements as &$element) {
            $element['children'] = [];
            $map[$element['id']] = &$element;
        }

        foreach ($elements as &$element) {
            if ($element['parent_id'] === null) {
                $tree[] = &$element;
            } else {
                if (isset($map[$element['parent_id']])) {
                    $map[$element['parent_id']]['children'][] = &$element;
                }
            }
        }

        return $tree;
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

    public function getBreadCrumbsRecursive($child_id, $language_id, $level = null): array
    {
        if (!is_numeric($child_id) && !is_null($child_id)) {
            return [];
        }

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

    public function filterIndexPage(int $perPage, array $params, int $language_id, int|null|string $id = null)
    {
        if (!is_numeric($id) && !is_null($id)) {
            return new LengthAwarePaginator([], 0, $perPage);
        }

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

        $values = $this
            ->model
            ->leftJoin((new OptionValueDescription())->getTable() . " as od", 'od.option_value_id', '=', 'option_values.id')
            ->where('od.language_id', 5)
            ->get();
        $valuesTree = $this->buildTree($values->toArray());
        $optionValue->setAttribute('values_tree', $valuesTree);

        return $optionValue;
    }

    public function upsert($input, $id = null)
    {
        $isCreating = is_null($id);

        $descriptions = $input['descriptions'] ?? [];
        $children_status = $input['children_status'] ?? 0;
        $input['level'] = 0;

        unset($input['descriptions'],$input['children_status']);

        $optionValue = isset($id) ? $this->model->find($id) : null;

        if ($optionValue) {
            $optionValue->fill($input);
            $optionValue->save();
        } else {
            $optionValue = new $this->model();
            $optionValue->fill($input);
            $optionValue->save();
            $id = $optionValue->id;
        }

        if ($isCreating && isset($input['parent_id'])) {
            $parent = $this->model->find($input['parent_id']);

            $input['level'] = $parent ? $parent->level+1 : 0;
        }

        foreach ($descriptions as $languageId => $descData) {
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

    public function delete($id) {
        $descendants = $this->model
            ->where('parent_id', $id)
            ->where('id', '<>', $id)
            ->get();

        foreach ($descendants as $descendant) {
            $this->delete($descendant->id);
        }

        $this->model->find($id)->delete();
    }
}
