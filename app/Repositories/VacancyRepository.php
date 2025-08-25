<?php

namespace App\Repositories;

use App\Models\Vacancy;
use App\Models\VacancyDescription;
use App\Repositories\BaseRepository;

class VacancyRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'location_id',
        'status'
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
        return Vacancy::class;
    }

    public function filterIndexPage(int $perPage, int $language_id, $params) {
        $vacancies = $this->model
            ->leftJoin((new VacancyDescription())->getTable() . " as vd", 'vd.vacancy_id', '=', 'vacancies.id')
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
