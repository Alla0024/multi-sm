<?php

namespace App\Repositories;

use App\Models\FirstPathQuery;
use App\Models\Information;
use App\Models\InformationDescription;
use App\Models\Store;
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

    public function find($id, $columns = ['*'])
    {
        $information = $this->model
            ->with([
                'stores',
                'descriptions' =>
                    function ($query) {
                        return $query->with('language');
                    },
                'firstPathQuery' => function ($query) {
                    return $query->select(['type_id', 'path']);
                },
            ])
            ->find($id, $columns);

        $preshaped_descriptions = [];
        $preshaped_stores = [];

        foreach ($information->descriptions as $description) {
            $preshaped_descriptions[$description->language->id] = [
                'name' => $description->name,
                'description' => $description->description,
            ];
        }

        foreach ($information->stores as $store) {
            $preshaped_stores[] = [
                'id' => $store->id,
                'text' => $store->name,
            ];
        }

        $seoPath = $information->firstPathQuery->path;
        unset($information->descriptions, $information->firstPathQuery, $information->stores);
        $information->setAttribute('descriptions', $preshaped_descriptions);
        $information->setAttribute('stores', $preshaped_stores);
        $information->setAttribute('path', $seoPath);

        return $information;
    }

    public function filterIndexPage($perPage, $language_id, $params)
    {
        $informations = $this->model
            ->with(['descriptions' => function ($query) use ($language_id) {
                $query->select('information_id', 'language_id', 'name')
                    ->where('language_id', $language_id);
            }])
            ->when(isset($params['sort_order']), function ($query) use ($params) {
                $query->where('sort_order', '=', $params['sort_order']);
            })
            ->when(isset($params['status']), function ($query) use ($params) {
                $query->where('status', '=', $params['status']);
            })
            ->when(isset($params['name']), function ($q) use ($params) {
                return $q->whereHas('descriptions', function ($q) use ($params) {
                    return $q->searchSimilarity(['name'], $params['name']);
                });
            })
            ->paginate($perPage);

        foreach ($informations as $information) {
            $name = $information->descriptions->first()->name ?? '';
            unset($information->descriptions);

            $information->setAttribute('name', $name);
        }

        return $informations;
    }

    public function create(array $input)
    {
        $descriptions = $input['descriptions'] ?? [];
        $seoPath = $input['path'];
        $stores = $input['stores'] ?? [];
        unset($input['descriptions'], $input['path'], $input['stores']);

        $information = $this->model->create($input);

        foreach ($descriptions as $languageId => $descData) {
            $descData['language_id'] = $languageId;
            $descData['information_id'] = $information->id;
            InformationDescription::create($descData);
        }

        $information->stores()->sync($stores);

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
        $stores = $input['stores'] ?? [];
        unset($input['descriptions'], $input['path'], $input['stores']);

        $information = $this->model->find($id);
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

        $information->stores()->sync($stores);

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

        $firstPathQuery?->delete();
        $information->delete();
    }
}
