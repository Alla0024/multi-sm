<?php

namespace App\Repositories;

use App\Models\FilterGroup;
use App\Repositories\BaseRepository;

class FilterGroupRepository extends BaseRepository
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
        return FilterGroup::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }
    public function filterRows($request)
    {
        $perPage = $request->integer('perPage', 10);
        $languageId = $request->input('language_id', config('settings.locale.default_language_id'));

        $query = $this->model::with([
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

        $filterGroups = $query->paginate($perPage);

        $filterGroups->getCollection()->transform(function ($item) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);

            return $item;
        });

        return $filterGroups;
    }
}
