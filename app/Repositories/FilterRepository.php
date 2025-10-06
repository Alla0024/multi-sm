<?php

namespace App\Repositories;

use App\Helpers\PictureHelper;
use App\Models\Filter;
use App\Models\FilterDescription;
use App\Models\FilterToOptionValueGroup;
use App\Models\FirstPathQuery;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class FilterRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'sort_order',
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
        return Filter::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function getFiltersByCategoryId($categoryId)
    {
        $filters = $this->model
            ->with([
                'descriptions' => function ($query) {
                    $query->where('language_id', 5);
                },
                'filterGroup.descriptions' => function ($query) {
                    $query->where('language_id', 5);
                }
            ])
            ->whereHas('categories', fn($q) => $q->where('categories.id', $categoryId))
            ->get()
            ->map(function ($filter) {
                return [
                    'id' => $filter->id,
                    'name' => $filter->descriptions->first()?->name,
                    'group_name' => $filter->filterGroup->descriptions->first()?->name,
                    'filter_group_id' => $filter->filter_group_id,
                ];
            });

        return $filters->groupBy('group_name')->toArray();
    }

    public function findFull($id, $columns = ['*'])
    {
        $filters = $this->model
            ->with([
                'descriptions.language:id,code',
                'optionValueGroups',
            ])
            ->where('filter_group_id', $id)
            ->get($columns);

        if ($filters->isEmpty()) {
            return collect();
        }


        return $filters->map(function ($filter) {
            $descriptions = $filter->descriptions
                ->mapWithKeys(fn($desc) => [
                    (string)($desc->language_id ?? $desc->language->id) => [
                        'name'       => $desc->name,
                        'meta_title' => $desc->meta_title,
                    ],
                ]);

            $filter->setRelation('optionValueGroups', $filter->optionValueGroups->keyBy('option_value_group_id'));

            return $filter->setRelation('descriptions', $descriptions);
        });
    }

    public function filterRows($request)
    {
        $perPage = $request->integer('perPage', 10);
        $languageId = $request->input('language_id', config('settings.locale.default_language_id'));

        $query = $this->model::with([
            'seoPath',
            'descriptions' => function ($q) use ($languageId) {
                $q->where('language_id', $languageId);
            }
        ]);

        foreach (['sort_order', 'status'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->input($field));
            }
        }

        if ($request->filled('name')) {
            $name = mb_strtolower($request->input('name'), 'UTF-8');

            $query->whereHas('descriptions', function ($q) use ($name, $languageId) {
                $q->where('language_id', $languageId)
                    ->whereRaw('LOWER(name) LIKE ?', ["%{$name}%"]);
            });
        }

        if ($request->filled('sortBy')) {
            $sortBy = $request->input('sortBy');

            switch ($sortBy) {
                case 'name_asc':
                    $query->withAggregate(['descriptions as name' => fn($q) => $q->where('language_id', $languageId)], 'name')
                        ->orderBy('name', 'asc');
                    break;

                case 'name_desc':
                    $query->withAggregate(['descriptions as name' => fn($q) => $q->where('language_id', $languageId)], 'name')
                        ->orderBy('name', 'desc');
                    break;

                case 'created_at':
                    $query->orderBy('created_at', 'asc');
                    break;

                case 'created_at_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        $filters = $query->paginate($perPage);

        $baseUrl = config('app.client_url');
        $filters->getCollection()->transform(function ($item) use ($baseUrl) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);

            $item->setAttribute('client_url', $item->seoPath
                ? rtrim($baseUrl, '/') . '/' . ltrim($item->seoPath->path, '/')
                : null
            );

            return $item;
        });

        return $filters;
    }

    public function save(array $input, ?int $id = null)
    {
        if (empty($input['filter'])) {
            Filter::where('filter_group_id', $id)->delete();
            return;
        }

        $keptFilterIds = [];

        foreach ($input['filter'] as $filterData) {

            $filterValues = [
                'sort_order' => $filterData['sort_order'] ?? 0,
                'path' => $filterData['path'] ?? '',
                'default_viewed' => $filterData['default_viewed'] ?? 0,
                'parent' => $filterData['parent'] ?? 0,
                'filter_group_id' => $id,
                'parent_id' => $filterData['parent_id'] ?? null,
            ];

            $filter = isset($filterData['filter_id'])
                ? tap(Filter::where('id', $filterData['filter_id']))->update($filterValues)
                : Filter::create($filterValues);

            $filterId = $filterData['filter_id'] ?? $filter->id;
            $keptFilterIds[] = $filterId;

            $optionGroupIds = $filterData['option_value_group_id'] ?? [];
            FilterToOptionValueGroup::where('filter_id', $filterId)->delete();

            if (!empty($optionGroupIds)) {
                $optionGroups = array_map(fn($gid) => [
                    'filter_id' => $filterId,
                    'option_value_group_id' => $gid
                ], $optionGroupIds);

                FilterToOptionValueGroup::insert($optionGroups);
            }

            $descriptions = $filterData['description'] ?? [];
            FilterDescription::where('filter_id', $filterId)->delete();

            if (!empty($descriptions)) {
                $descInsert = [];
                foreach ($descriptions as $langId => $descData) {
                    $descInsert[] = array_merge(
                        ['filter_id' => $filterId, 'language_id' => $langId],
                        $descData
                    );
                }
                FilterDescription::insert($descInsert);
            }
        }

        Filter::where('filter_group_id', $id)
            ->whereNotIn('id', $keptFilterIds)
            ->delete();
    }

    public function copy($ids): void
    {
        $filters = Filter::with(['descriptions', 'optionValueGroups'])
            ->whereIn('filter_group_id', $ids)
            ->get();

        foreach ($filters as $filter) {
            $newFilter = $filter->replicate();
            $newFilter->path = $filter->path . '_copy';
            $newFilter->save();

            if ($filter->descriptions->isNotEmpty()) {
                $newDescriptions = $filter->descriptions->map(function ($desc) use ($newFilter) {
                    $newDesc = $desc->replicate();
                    $newDesc->filter_id = $newFilter->id;
                    return $newDesc->toArray();
                })->toArray();

                FilterDescription::insert($newDescriptions);
            }

            if ($filter->optionValueGroups->isNotEmpty()) {
                $newRelations = $filter->optionValueGroups->map(function ($relation) use ($newFilter) {
                    return [
                        'filter_id' => $newFilter->id,
                        'option_value_group_id' => $relation->option_value_group_id,
                    ];
                })->toArray();

                FilterToOptionValueGroup::insert($newRelations);
            }
        }
    }

    public function multiDelete($ids): void
    {
        FilterDescription::whereIn('filter_id', $ids)->delete();
        FilterToOptionValueGroup::whereIn('filter_id', $ids)->delete();
        Filter::whereIn('id', $ids)->delete();
    }
}
