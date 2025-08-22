<?php

namespace App\Repositories;

use App\Models\Manufacturer;
use App\Models\ManufacturerDescription;
use Illuminate\Database\Eloquent\Builder;

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

    public function with($relations): Builder
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

    public function filterIndexPage($input, $perPage, $languageId)
    {
        return $this->model
            ->leftJoin((new ManufacturerDescription())->getTable() . " as md", 'md.manufacturer_id', '=', 'manufacturers.id')
            ->where('md.language_id', $languageId)
            ->when(isset($input['name']), function ($q) use ($input) {
                return $q->searchSimilarity(['md.name'], $input['name']);
            })
            ->paginate($perPage);
    }
}
