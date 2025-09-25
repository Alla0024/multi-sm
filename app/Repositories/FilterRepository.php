<?php

namespace App\Repositories;

use App\Helpers\PictureHelper;
use App\Models\Filter;
use App\Models\FilterDescription;
use App\Models\FirstPathQuery;
use App\Repositories\BaseRepository;

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

    public function findFull($id, $columns = ['*'])
    {
        $filter = $this->model
            ->with([
                'descriptions.language:id,code',
                'optionValueGroups'
            ])
            ->where('filter_group_id', $id)
            ->first($columns);

        if (!$filter) {
            return null;
        }

        $descriptions = $filter->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language->code ?? $desc->language_id) => [
                    'name'       => $desc->name,
                    'meta_title' => $desc->meta_title,
                ],
            ])
            ->toArray();

        return $filter->setRelation('descriptions', $descriptions);
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
        $seoPath = $input['path'] ?? null;
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions'], $input['path'], $input['stores']);

        $filterSave = $input;

        if (!empty($input['image'])) {
            PictureHelper::rewrite(
                $input['image'],
                config('settings.images.filter.width'),
                config('settings.images.filter.height')
            );

            if (str_contains($input['image'], 'storage/images')) {
                $input['image'] = substr($input['image'], 15);
            }

            $filterSave['image'] = $input['image'];
        }

        $filter = $this->model->updateOrCreate(['id' => $id], $filterSave);

        foreach ($descriptions as $languageId => $descData) {
            FilterDescription::updateOrInsert(
                [
                    'filter_id' => (int)$filter->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        $seoPath && FirstPathQuery::updateOrCreate(
            ['type' => 'filter', 'type_id' => $filter->id],
            ['path' => $seoPath]
        );

        return $filter;
    }

    public function copy($ids): void
    {
        $filters = Filter::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($filters as $filter) {
            $newFilter = $filter->replicate();
            $newFilter->save();

            foreach ($filter->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->filter_id = $newFilter->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        Filter::whereIn('id', $ids)->delete();
        FilterDescription::whereIn('filter_id', $ids)->delete();
        FirstPathQuery::where('type', 'filter')->whereIn('type_id', $ids)->delete();
    }
}
