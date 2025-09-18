<?php

namespace App\Repositories;

use App\Models\OptionValue;
use App\Models\OptionValueDescription;
use App\Repositories\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Http\Request;
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

    public function getValuesTree(): array
    {
        $elements = $this
            ->model
            ->leftJoin((new OptionValueDescription())->getTable() . " as od", 'od.option_value_id', '=', 'option_values.id')
            ->where('od.language_id', 5)
            ->get()
            ->toArray();

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

    private function copyRecursive(int $parent_id, int $new_parent_id): void
    {
        $descendants = $this->model->where('parent_id', $parent_id)->with('descriptions')->get();

        foreach ($descendants as $descendant) {
            $new = $descendant->replicate();
            $new->parent_id = $new_parent_id;
            $new->save();

            foreach ($descendant->descriptions as $description) {
                $newDescription = $description->toArray();
                $newDescription['option_value_id'] = $new->id;
                OptionValueDescription::create($newDescription);
            }

            $this->copyRecursive($descendant->id, $new->id);
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

    public function filterRows(Request $request, int|null|string $id = null)
    {
        $perPage = $request->get('perPage', 10);
        $params = $request->all();
        $language_id = $request->get('language_id', config('settings.locale.default_language_id'));

        $query = $this
            ->model
            ->leftJoin((new OptionValueDescription())->getTable() . " as od", 'od.option_value_id', '=', 'option_values.id')
            ->where('od.language_id', $language_id)
            ->where('parent_id', $id)
            ->when(isset($params['name']), function ($q) use ($params) {
                return $q->searchSimilarity(['od.name'], $params['name']);
            });

        if ($request->filled('name')) {
            $name = mb_strtolower($request->input('name'), 'UTF-8');

            $query->where('name', 'LIKE', "%{$name}%");
        }

        if ($request->filled('level')) {
            $query->where('level', $request->get('level'));
        }

        if ($request->filled('sort_order')) {
            $query->where('sort_order', $request->get('sort_order'));
        }

        $query->when(isset($params['sortBy']), function ($query) use ($params) {
            switch ($params['sortBy']) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'created_at':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'created_at_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    break;
            }

            return $query;
        });

        return $query->paginate($perPage);
    }

    public function findFull($id)
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

    public function save($input, $id = null)
    {
        $isCreating = is_null($id);

        $descriptions = $input['descriptions'] ?? [];
        $children_status = $input['children_status'] ?? 0;
        $input['level'] = 0;
        $input['image'] = $input['image'] ?? '';

        unset($input['descriptions'], $input['children_status']);

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

            $input['level'] = $parent ? $parent->level + 1 : 0;
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

    public function delete($id)
    {
        $descendants = $this->model
            ->where('parent_id', $id)
            ->where('id', '<>', $id)
            ->get();

        foreach ($descendants as $descendant) {
            $this->delete($descendant->id);
        }

        $this->model->find($id)->delete();
    }

    public function multiDelete($ids): void
    {
        foreach ($ids as $id) {
            $this->delete($id);
        }
    }

    public function copy($ids): void
    {
        $optionValues = OptionValue::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($optionValues as $optionValue) {
            $newOptionValue = $optionValue->replicate();
            $newOptionValue->save();

            foreach ($optionValue->descriptions as $description) {
                $newDescription = $description->toArray();
                $newDescription['option_value_id'] = $newOptionValue->id;
                OptionValueDescription::create($newDescription);
            }

            $this->copyRecursive($optionValue->id, $newOptionValue->id);
        }
    }
}
