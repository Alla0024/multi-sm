<?php

namespace App\Repositories;

use App\Models\FirstPathQuery;
use App\Models\Information;
use App\Models\InformationDescription;
use App\Models\Store;
use App\Repositories\BaseRepository;
use Illuminate\Container\Container as Application;

class InformationRepository extends BaseRepository
{
    /**
     * @var FirstPathQueryRepository $firstPathQueryRepository;
     */
    private FirstPathQueryRepository $firstPathQueryRepository;

    public function __construct(
        Application $app,
        FirstPathQueryRepository $firstPathQueryRepo
    )
    {
        $this->firstPathQueryRepository = $firstPathQueryRepo;

        parent::__construct($app);
    }

    protected $fieldSearchable = [
        'sort_order',
        'status'
    ];

    protected $additionalFields = [
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

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function find($id, $columns = ['*'])
    {
        $information = $this->model
            ->with([
                'stores' =>
                    function ($query) {
                        return $query->select(['id', 'name']);
                    },
                'descriptions' =>
                    function ($query) {
                        return $query->with('language');
                    },
                'seoPath' => function ($query) {
                    return $query->select(['type_id', 'path']);
                },
            ])
            ->find($id, $columns);

        if (empty($information)) {
            return $information;
        }

        $preshaped_descriptions = [];

        foreach ($information->descriptions as $description) {
            $preshaped_descriptions[$description->language->id] = [
                'name' => $description->name,
                'description' => $description->description,
            ];
        }

        $seoPath = $information->seoPath->path ?? '';
        unset($information->descriptions, $information->seoPath);
        $information->setAttribute('descriptions', $preshaped_descriptions);
        $information->setAttribute('path', $seoPath);

        return $information;
    }

    public function filterIndexPage($perPage, $language_id, $params)
    {
        $informations = $this->model
            ->with(['descriptions' => function ($query) use ($language_id) {
                $query->select('information_id', 'language_id', 'name')
                    ->where('language_id', $language_id);
                },
                'seoPath'
            ])
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

    public function upsert(array $input, int|null $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];
        $seoPath = $input['path'];
        $stores = $input['stores'] ?? [];
        unset($input['descriptions'], $input['path'], $input['stores']);

        $information = isset($id) ? $this->model->find($id) : null;

        if (!$information) {
            $information = new $this->model();
        }

        $information->fill($input);
        $information->save();

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

        $this->firstPathQueryRepository->upsert($information->id, 'information', $seoPath);

        return $information;
    }

    public function delete($id) {
        $information = $this->find($id);

        $firstPathQuery = FirstPathQuery::where(['type' => 'information', 'type_id' => $id ])->first();

        $firstPathQuery?->delete();
        $information->delete();
    }
}
