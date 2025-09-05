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

        $manufacturers = $query->paginate($perPage);

        $baseUrl = config('app.client_url');
        $manufacturers->getCollection()->transform(function ($item) use ($baseUrl) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);

            $item->setAttribute('client_url', $item->seoPath
                ? rtrim($baseUrl, '/') . '/' . ltrim($item->seoPath->path, '/')
                : null
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
