<?php

namespace App\Repositories;

use App\Models\Option;
use App\Models\OptionDescription;
use App\Repositories\BaseRepository;

class OptionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'name',
        'value_groups_count',
        'sort_order',
    ];

    protected array $additionalFields = [
        'name',
        'value_groups_count',
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
        return Option::class;
    }

    public function find($id, $columns = ['*'])
    {
        $option = $this->model->find($id, $columns);

        return $option;
    }

    public function filterIndexPage($perPage, $language_id, array $params)
    {
        $options = $this->model
            ->leftJoin((new OptionDescription())->getTable() . " as od", 'od.option_id', '=', 'options.id')
            ->select('options.*', 'od.*')
            ->where('od.language_id', $language_id)
            ->withCount('optionValueGroups as value_groups_count')
            ->when(isset($params['name']), function ($q) use ($params) {
                return $q->searchSimilarity(['od.name'], $params['name']);
            })
            ->paginate($perPage);

        return $options;
    }
}
