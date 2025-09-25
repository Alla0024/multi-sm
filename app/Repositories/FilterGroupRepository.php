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

    public function findFull($id, $columns = ['*'])
    {
        $filterGroup = $this->model
            ->with([
                'descriptions.language:id,code',
                'option'
            ])
            ->find($id, $columns);

        if (!$filterGroup) {
            return null;
        }

        $descriptions = $filterGroup->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'name' => $desc->name,
                    'comment' => $desc->comment,
                    'meta_title' => $desc->meta_title,
                ]
            ])
            ->toArray();

        return $filterGroup
            ->setRelation('descriptions', $descriptions);
    }


    public function filterRows(array $input)
    {
        $perPage = $input['perPage'] ?? 10;
        $languageId = $input['language_id'] ?? config('settings.locale.default_language_id');

        $query = $this->model::with([
            'descriptions' => fn($q) => $q->where('language_id', $languageId),
        ]);

        foreach (['sort_order', 'status'] as $field) {
            $query->when($input[$field] ?? null, fn($q, $value) => $q->where($field, $value));
        }

        $query->when($input['name'] ?? null, function ($q, $name) use ($languageId) {
            $q->whereHas('descriptions', fn($sub) => $sub
                ->where('language_id', $languageId)
                ->where('name', 'LIKE', "%{$name}%")
            );
        });

        $sortOptions = [
            'name_asc' => fn($q) => $q->withAggregate(
                ['descriptions as name' => fn($sq) => $sq->where('language_id', $languageId)],
                'name'
            )->orderBy('name', 'asc'),

            'name_desc' => fn($q) => $q->withAggregate(
                ['descriptions as name' => fn($sq) => $sq->where('language_id', $languageId)],
                'name'
            )->orderBy('name', 'desc'),

            'created_at_asc' => fn($q) => $q->orderBy('created_at', 'asc'),
            'created_at_desc' => fn($q) => $q->orderBy('created_at', 'desc'),
        ];

        $query->when($input['sortBy'] ?? null, fn($q, $sortBy) => $sortOptions[$sortBy]($q) ?? null);

        return $query->paginate($perPage)->through(function ($item) {
            $item->name = optional($item->descriptions->first())->name;
            return $item;
        });
    }
}
