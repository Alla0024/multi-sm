<?php

namespace App\Repositories;

use App\Helpers\PictureHelper;
use App\Models\FirstPathQuery;
use App\Models\Manufacturer;
use App\Models\ManufacturerDescription;

class ManufacturerRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'sort_order',
    ];

    protected $additionalFields = [
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
        return Manufacturer::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $manufacturer = $this->model
            ->with([
                'descriptions.language:id,code',
                'seoPath:type_id,path',
            ])
            ->find($id, $columns);

        if (!$manufacturer) {
            return null;
        }

        $descriptions = $manufacturer->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'name' => $desc->name,
                    'description' => $desc->description,
                    'tag' => $desc->tag,
                ]
            ])
            ->toArray();

        return $manufacturer
            ->setRelation('descriptions', $descriptions)
            ->setAttribute('path', $manufacturer->seoPath->path ?? '')
            ->makeHidden('seoPath');
    }

    public function filterRows(array $input)
    {
        $perPage    = $input['perPage'] ?? 10;
        $languageId = $input['language_id'] ?? config('settings.locale.default_language_id');

        $query = $this->model::with([
            'seoPath',
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

        $manufacturers = $query->paginate($perPage);

        $baseUrl = rtrim(config('app.client_url'), '/');
        $manufacturers->getCollection()->transform(function ($item) use ($baseUrl) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);
            $item->setAttribute(
                'client_url',
                $item->seoPath ? $baseUrl . '/' . ltrim($item->seoPath->path, '/') : null
            );
            return $item;
        });

        return $manufacturers;
    }

    public function save(array $input, ?int $id = null)
    {
        $seoPath = $input['path'] ?? null;
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions'], $input['path'], $input['stores']);

        $manufacturerSave = $input;

        if (!empty($input['image'])) {
            PictureHelper::rewrite(
                $input['image'],
                config('settings.images.manufacturer.width'),
                config('settings.images.manufacturer.height')
            );

            if (str_contains($input['image'], 'storage/images')) {
                $input['image'] = substr($input['image'], 15);
            }

            $manufacturerSave['image'] = $input['image'];
        }

        $manufacturer = $this->model->updateOrCreate(['id' => $id], $manufacturerSave);

        foreach ($descriptions as $languageId => $descData) {
            ManufacturerDescription::updateOrInsert(
                [
                    'manufacturer_id' => (int)$manufacturer->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        $seoPath && FirstPathQuery::updateOrCreate(
            ['type' => 'manufacturer', 'type_id' => $manufacturer->id],
            ['path' => $seoPath]
        );

        return $manufacturer;
    }

    public function copy($ids): void
    {
        $manufacturers = Manufacturer::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($manufacturers as $manufacturer) {
            $newManufacturer = $manufacturer->replicate();
            $newManufacturer->save();

            foreach ($manufacturer->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->manufacturer_id = $newManufacturer->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        Manufacturer::whereIn('id', $ids)->delete();
        ManufacturerDescription::whereIn('manufacturer_id', $ids)->delete();
        FirstPathQuery::where('type', 'manufacturer')->whereIn('type_id', $ids)->delete();
    }
}
