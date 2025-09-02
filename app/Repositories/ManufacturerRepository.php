<?php

namespace App\Repositories;

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

    public function create(array $input)
    {
        $descriptions = $input['descriptions'] ?? [];
        unset($input['descriptions']);

        $manufacturer = $this->model->create($input);

        foreach ($descriptions as $languageId => $descData) {
            $descData['language_id'] = $languageId;
            $descData['manufacturer_id'] = $manufacturer->id;
            ManufacturerDescription::create($descData);
        }

        return $manufacturer;
    }

    public function update(array $input, $id)
    {
        $descriptions = $input['descriptions'] ?? [];
        unset($input['descriptions']);

        $manufacturer = $this->find($id);
        $manufacturer->update($input);

        foreach ($descriptions as $languageId => $descData) {
            ManufacturerDescription::updateOrCreate(
                [
                    'manufacturer_id' => $manufacturer->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        return $manufacturer;
    }
    public function find($id, $columns = ['*'])
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
            ->mapWithKeys(fn ($desc) => [
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

    public function filterIndexPage($request)
    {
        $params = $request->all();
        $perPage = $request->get('per_page', 20);
        $languageId = $request->get('language_id', config('settings.locale.default_language_id'));

        return $this->model
            ->leftJoin((new ManufacturerDescription())->getTable() . " as md", 'md.manufacturer_id', '=', 'manufacturers.id')
            ->where('md.language_id', $languageId)
            ->when(isset($input['name']), function ($q) use ($params) {
                return $q->searchSimilarity(['md.name'], $params['name']);
            })
            ->paginate($perPage);
    }
}
