<?php

namespace App\Repositories;

use App\Models\Province;
use App\Models\ProvinceDescription;
use App\Repositories\BaseRepository;

class ProvinceRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'code'
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
        return Province::class;
    }


    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $province = $this->model
            ->with([
                'descriptions.language:id,code',
            ])
            ->find($id, $columns);

        if (!$province) {
            return null;
        }

        $descriptions = $province->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'name' => $desc->name,
                ]
            ])
            ->toArray();

        return $province
            ->setRelation('descriptions', $descriptions);
    }

    public function filterRows(array $input)
    {
        $perPage    = $input['perPage'] ?? 10;
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

        $provinces = $query->paginate($perPage);

        $provinces->getCollection()->transform(function ($item) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);
            return $item;
        });

        return $provinces;
    }

    public function save(array $input, ?int $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions']);

        $provinceSave = $input;

        $province = $this->model->updateOrCreate(['id' => $id], $provinceSave);

        foreach ($descriptions as $languageId => $descData) {
            ProvinceDescription::updateOrInsert(
                [
                    'province_id' => (int)$province->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        return $province;
    }

    public function copy($ids): void
    {
        $provinces = Province::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($provinces as $province) {
            $newProvince = $province->replicate();
            $newProvince->save();

            foreach ($province->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->province_id = $newProvince->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        Province::whereIn('id', $ids)->delete();
        ProvinceDescription::whereIn('province_id', $ids)->delete();
    }
}
