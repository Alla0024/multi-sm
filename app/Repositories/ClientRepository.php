<?php

namespace App\Repositories;

use App\Models\Client;
use App\Repositories\BaseRepository;

class ClientRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'surname',
        'name',
        'email',
        'phone',
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
        return Client::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        return $this->model
            ->find($id, $columns);
    }

    public function filterRows(array $input)
    {
        $perPage = $input['perPage'] ?? 10;

        $query = $this->model->newQuery();

        foreach (['sort_order', 'status'] as $field) {
            $query->when($input[$field] ?? null, fn($q, $value) => $q->where($field, $value));
        }

        $query->when($input['surname'] ?? null, fn($q, $surname) => $q->where('surname', 'LIKE', "%{$surname}%")
        );

        $query->when($input['name'] ?? null, fn($q, $name) => $q->where('name', 'LIKE', "%{$name}%")
        );

        $query->when($input['email'] ?? null, fn($q, $email) => $q->where('email', 'LIKE', "%{$email}%")
        );

        $query->when($input['phone'] ?? null, fn($q, $phone) => $q->where('phone', 'LIKE', "%{$phone}%")
        );

        $query->when($input['sortBy'] ?? null, function ($q, $sortBy) {
            if ($sortBy === 'name_asc') {
                $q->orderBy('name', 'asc');
            } elseif ($sortBy === 'name_desc') {
                $q->orderBy('name', 'desc');
            } elseif ($sortBy === 'created_at_asc') {
                $q->orderBy('created_at', 'asc');
            } elseif ($sortBy === 'created_at_desc') {
                $q->orderBy('created_at', 'desc');
            }
        });

        return $query->paginate($perPage);
    }


    public function save(array $input, ?int $id = null)
    {
        return $this->model->updateOrCreate(['id' => $id], $input);
    }
}
