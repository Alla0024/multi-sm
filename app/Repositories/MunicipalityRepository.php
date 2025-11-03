<?php

namespace App\Repositories;

use App\Models\Municipality;
use App\Models\MunicipalityDescription;
use App\Repositories\BaseRepository;

class MunicipalityRepository extends BaseRepository
{
    protected array $fieldSearchable = [

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
        return Municipality::class;
    }
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $municipality = $this->model
            ->with([
                'descriptions.language:id,code',
            ])
            ->find($id, $columns);

        if (!$municipality) {
            return null;
        }

        $descriptions = $municipality->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'name' => $desc->name,
                    'description' => $desc->description,
                    'tag' => $desc->tag,
                ]
            ])
            ->toArray();

        return $municipality
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

        $municipalities = $query->paginate($perPage);

        $municipalities->getCollection()->transform(function ($item) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);
            return $item;
        });

        return $municipalities;
    }

    public function save(array $input, ?int $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions']);

        $municipalitySave = $input;

        $municipality = $this->model->updateOrCreate(['id' => $id], $municipalitySave);

        foreach ($descriptions as $languageId => $descData) {
            MunicipalityDescription::updateOrInsert(
                [
                    'municipality_id' => (int)$municipality->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        return $municipality;
    }

    public function copy($ids): void
    {
        $municipalities = Municipality::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($municipalities as $municipality) {
            $newMunicipality = $municipality->replicate();
            $newMunicipality->save();

            foreach ($municipality->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->municipality_id = $newMunicipality->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        Municipality::whereIn('id', $ids)->delete();
        MunicipalityDescription::whereIn('municipality_id', $ids)->delete();
    }
}

