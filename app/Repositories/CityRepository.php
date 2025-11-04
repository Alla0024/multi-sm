<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\CityDescription;
use App\Repositories\BaseRepository;

class CityRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'status'
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
        return City::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $city = $this->model
            ->with([
                'descriptions.language:id,code',
            ])
            ->find($id, $columns);

        if (!$city) {
            return null;
        }

        $descriptions = $city->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'name' => $desc->name,
                ]
            ])
            ->toArray();

        return $city
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

        $cities = $query->paginate($perPage);

        $cities->getCollection()->transform(function ($item) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);
            return $item;
        });

        return $cities;
    }

    public function save(array $input, ?int $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions']);

        $citySave = $input;

        $city = $this->model->updateOrCreate(['id' => $id], $citySave);

        foreach ($descriptions as $languageId => $descData) {
            CityDescription::updateOrInsert(
                [
                    'city_id' => (int)$city->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        return $city;
    }

    public function copy($ids): void
    {
        $cities = City::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($cities as $city) {
            $newCity = $city->replicate();
            $newCity->save();

            foreach ($city->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->city_id = $newCity->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        City::whereIn('id', $ids)->delete();
        CityDescription::whereIn('city_id', $ids)->delete();
    }
}
