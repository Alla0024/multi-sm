<?php

namespace App\Repositories;

use App\Models\FirstPathQuery;
use App\Models\Information;
use App\Models\InformationDescription;
use App\Models\InformationToStore;
use Illuminate\Database\Eloquent\Builder;

class InformationRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'sort_order',
        'status'
    ];

    protected array $additionalFields = [
        'stores' => [
            'validations' => 'nullable|array',
        ]
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
        return Information::class;
    }

    public function with($relations): Builder
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $information = $this->model
            ->with([
                'stores:id,name',
                'descriptions.language:id,code',
                'seoPath:type_id,path',
            ])
            ->find($id, $columns);

        if (!$information) {
            return null;
        }

        $descriptions = $information->descriptions
            ->mapWithKeys(fn($desc) => [
                $desc->language->id => [
                    'name' => $desc->name,
                    'description' => $desc->description,
                ]
            ])
            ->toArray();

        return $information
            ->setRelation('descriptions', $descriptions)
            ->setAttribute('path', $information->seoPath->path ?? '')
            ->makeHidden('seoPath');
    }

    public function filterRows($request)
    {
        $perPage = $request->integer('perPage', 10);
        $languageId = $request->input('language_id', config('settings.locale.default_language_id'));
        $params = $request->all();

        $query = $this->model::with(['seoPath'])
        ->leftJoin((new InformationDescription())->getTable() . " as ind", 'ind.information_id', '=', 'informations.id')
        ->where('ind.language_id', $languageId);

        if ($request->filled('sort_order')) {
            $query->where('sort_order', $request->input('sort_order'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('name')) {
            $name = mb_strtolower($request->input('name'), 'UTF-8');

            $query->where('name', 'LIKE', "%{$name}%");
        }

        $query->when(isset($params['sortBy']), function ($query) use ($params) {
            switch ($params['sortBy']) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'created_at':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'created_at_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    break;
            }

            return $query;
        });

        $informationList = $query->paginate($perPage);

        $baseUrl = config('app.client_url');

        $informationList->getCollection()->transform(function ($item) use ($baseUrl) {
            if ($item->seoPath) {
                $path = $item->seoPath->path;
                $item->setAttribute('client_url', rtrim($baseUrl, '/') . '/' . ltrim($path, '/'));
            } else {
                $item->setAttribute('client_url', null);
            }

            unset($item->descriptions);
            return $item;
        });

        return $informationList;
    }

    public function save(array $input, ?int $id = null)
    {
        $seoPath = $input['path'] ?? null;
        $stores = $input['stores'] ?? [];
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions'], $input['path'], $input['stores']);

        $information = $this->model->updateOrCreate(['id' => $id], $input);

        foreach ($descriptions as $languageId => $descData) {
            InformationDescription::updateOrCreate(
                [
                    'information_id' => $information->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        $stores && $information->stores()->sync($stores);

        $seoPath && FirstPathQuery::updateOrCreate(
            ['type' => 'information', 'type_id' => $information->id],
            ['path' => $seoPath]
        );

        return $information;
    }

    public function delete($id)
    {
        $this->find($id)?->delete();

        FirstPathQuery::where('type', 'information')
            ->where('type_id', $id)
            ->first()?->delete();
    }

    public function copy($ids): void
    {
        $informations = Information::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($informations as $information) {
            $newInformation = $information->replicate();
            $newInformation->status = 0;
            $newInformation->save();

            $stores = InformationToStore::where(['information_id' => $information->id])->get();

            foreach ($stores as $store) {
                $newStore = $store->toArray();
                $newStore['information_id'] = $newInformation->id;
                InformationToStore::create($newStore);
            }

            foreach ($information->descriptions as $description) {
                $newDescription = $description->toArray();
                $newDescription['information_id'] = $newInformation->id;
                InformationDescription::create($newDescription);
            }
        }
    }

    public function multiDelete($ids): void
    {
        Information::whereIn('id', $ids)->delete();
        InformationDescription::whereIn('information_id', $ids)->delete();
        InformationToStore::whereIn('information_id', $ids)->delete();
        FirstPathQuery::where('type', 'information')->whereIn('type_id', $ids)->delete();
    }
}
