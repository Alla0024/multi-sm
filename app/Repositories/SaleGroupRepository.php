<?php

namespace App\Repositories;

use App\Models\SaleGroup;
use App\Models\SaleGroupDescription;

class SaleGroupRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'type',
        'status',
        'sort_order'
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
        return SaleGroup::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $saleGroup = $this->model
            ->with([
                'descriptions.language:id,code',
            ])
            ->find($id, $columns);

        if (!$saleGroup) {
            return null;
        }

        $descriptions = $saleGroup->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'name' => $desc->name,
                ]
            ])
            ->toArray();

        return $saleGroup
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
            $q->whereHas('descriptions', function ($sub) use ($languageId, $name) {
                $sub->where('language_id', $languageId)
                    ->where('name', 'LIKE', "%{$name}%");
            });
        });

        $query->when($input['sortBy'] ?? null, function ($q, $sortBy) use ($languageId) {
            if (in_array($sortBy, ['name_asc', 'name_desc'])) {
                $q->withAggregate(
                    ['descriptions as name' => fn($sub) => $sub->where('language_id', $languageId)],
                    'name'
                )->orderBy('name', $sortBy === 'name_asc' ? 'asc' : 'desc');
            } elseif ($sortBy === 'created_at_asc') {
                $q->orderBy('created_at', 'asc');
            } elseif ($sortBy === 'created_at_desc') {
                $q->orderBy('created_at', 'desc');
            }
        });

        $saleGroups = $query->paginate($perPage);

        $saleGroups->getCollection()->transform(function ($item) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);
            return $item;
        });

        return $saleGroups;
    }

    public function save(array $input, ?int $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions']);

        $saleGroupSave = $input;

        $saleGroup = $this->model->updateOrCreate(['id' => $id], $saleGroupSave);

        foreach ($descriptions as $languageId => $descData) {
            SaleGroupDescription::updateOrInsert(
                [
                    'sale_group_id' => (int)$saleGroup->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        return $saleGroup;
    }

    public function multiDelete($ids): void
    {
        SaleGroup::whereIn('id', $ids)->delete();
        SaleGroupDescription::whereIn('sale_group_id', $ids)->delete();
    }
}

