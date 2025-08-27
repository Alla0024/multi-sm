<?php

namespace App\Repositories;

use App\Models\Location;
use App\Models\Vacancy;
use App\Models\VacancyDescription;
use App\Repositories\BaseRepository;

class VacancyRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'location_id',
        'status'
    ];

    protected array $additionalFields = [];

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
        return Vacancy::class;
    }

    public function filterIndexPage(int $perPage, int $language_id, $params) {
        $vacancies = $this->model
            ->leftJoin((new VacancyDescription())->getTable() . " as vd", 'vd.vacancy_id', '=', 'vacancies.id')
            ->with(['location' => function($query) use ($language_id) {
                return $query->select('id')->with(['descriptions' => function($query) use ($language_id) {
                    return $query->where('language_id', $language_id);
                }]);
            }])
            ->where('vd.language_id', $language_id)
            ->select(['id', 'title', 'location_id', 'status'])
            ->when(isset($params['title']), function ($q) use ($params) {
                return $q->searchSimilarity(['vd.title'], $params['title']);
            })
            ->when(isset($params['status']), function ($q) use ($params) {
                return $q->where('status', $params['status']);
            })
            ->when(isset($params['location_id']), function ($q) use ($params) {
                return $q->where('location_id', $params['location_id']);
            })
            ->paginate($perPage);

        $vacancies->getCollection()->transform(function ($item) {
            $location = $item->location->descriptions->first()->name;
            unset($item->location, $item->location_id);
            $item->location_id = $location;
            return $item;
        });

        return $vacancies;
    }

    public function getDetails($id)
    {
        $vacancy = $this->model
            ->with(['descriptions'])
            ->find($id);

        $descriptions = $vacancy->descriptions->keyBy('language_id')->toArray();
        unset($vacancy->descriptions);
        $vacancy->setAttribute('descriptions', $descriptions);

        return $vacancy;
    }

    public function upsert(array $input, $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];
        unset($input['descriptions']);

        $vacancy = isset($id) ? $this->model->find($id) : null;

        if (!$vacancy) {
            $vacancy = new $this->model();
        }

        $vacancy->fill($input);
        $vacancy->save();

        $id = $id ?? $vacancy->id;

        foreach ($descriptions as $languageId => $descData) {
            VacancyDescription::updateOrCreate(
                [
                    'vacancy_id' => $id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        return $vacancy;
    }
}
