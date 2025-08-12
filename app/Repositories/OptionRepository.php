<?php

namespace App\Repositories;

use App\Models\Option;
use App\Repositories\BaseRepository;

class OptionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'type',
        'sort_order',
        'path'
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
        return Option::class;
    }

    public function find($id, $columns = ['*'])
    {
        $option = $this->model->find($id, $columns);

        return $option;
    }

    public function paginate($perPage = 15, $columns = ['*'])
    {
        $options = $this->model
            ->withCount('optionValueGroups')
            ->paginate($perPage, $columns);



        return $options;
    }
}
