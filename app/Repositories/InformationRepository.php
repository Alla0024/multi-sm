<?php

namespace App\Repositories;

use App\Models\FirstPathQuery;
use App\Models\Information;
use App\Models\InformationDescription;
use App\Repositories\BaseRepository;

class InformationRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'sort_order',
        'status'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Information::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function create(array $input)
    {
        $descriptions = $input['descriptions'] ?? [];
        $seoPath = $input['path'];
        unset($input['descriptions'], $input['path']);

        $information = $this->model->create($input);

        foreach ($descriptions as $languageId => $descData) {
            $descData['language_id'] = $languageId;
            $descData['information_id'] = $information->id;
            InformationDescription::create($descData);
        }

        $firstPathQuery = FirstPathQuery::create([
            'type' => 'information',
            'type_id' => $information->id,
            'path' => $seoPath,
        ]);

        return $information;
    }

    public function update(array $input, $id)
    {
        $descriptions = $input['descriptions'] ?? [];
        $seoPath = $input['path'];
        unset($input['descriptions'], $input['path']);

        $information = $this->find($id);
        $information->update($input);

        foreach ($descriptions as $languageId => $descData) {
            InformationDescription::updateOrCreate(
                [
                    'information_id' => $information->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        $firstPathQueryData = [
            'type' => 'information',
            'type_id' => $id,
        ];

        $firstPathQuery = FirstPathQuery::where($firstPathQueryData)->first();

        if (!$firstPathQuery) {
            FirstPathQuery::create([
                ...$firstPathQueryData,
                'path' => $seoPath,
            ]);
        } else {
            $firstPathQuery->update([
                'path' => $seoPath,
            ]);
        }

        return $information;
    }

    public function delete($id) {
        $information = $this->find($id);

        $firstPathQuery = FirstPathQuery::where(['type' => 'information', 'type_id' => $id ])->first();

        if (!$firstPathQuery) {
            throw new \Error('First path query not found.');
        }

        $firstPathQuery->delete();
        $information->delete();
    }
}
