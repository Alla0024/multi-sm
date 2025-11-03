<?php

namespace App\Repositories;

use App\Models\IndividualEntrepreneur;
use App\Repositories\BaseRepository;

class IndividualEntrepreneurRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'name',
        'store_id',
        'store_key',
        'token',
        'status',
        'sort_order',
        'bank_id',
        'date_start',
        'date_end'
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
        return IndividualEntrepreneur::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $individualEntrepreneur = $this->model
            ->with([
                'paymentMethods',
            ])
            ->find($id, $columns);

        if (!$individualEntrepreneur) {
            return null;
        }

        return $individualEntrepreneur;

    }

    public function filterRows(array $input)
    {
        $perPage = $input['perPage'] ?? 10;

        $query = $this->model::with([
            'paymentMethods',
        ]);

        foreach (['sort_order', 'status'] as $field) {
            $query->when($input[$field] ?? null, fn($q, $value) => $q->where($field, $value));
        }

        $query->when($input['name'] ?? null, function ($q, $name) {
            $q->where('name', 'LIKE', "%{$name}%");
        });

        $query->when($input['sortBy'] ?? null, function ($q, $sortBy) {
            switch ($sortBy) {
                case 'name_asc':
                    $q->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $q->orderBy('name', 'desc');
                    break;
                case 'created_at_asc':
                    $q->orderBy('created_at', 'asc');
                    break;
                case 'created_at_desc':
                    $q->orderBy('created_at', 'desc');
                    break;
            }
        });

        return $query->paginate($perPage);
    }

    public function save(array $input, ?int $id = null)
    {
        $individualEntrepreneur = $this->model->updateOrCreate(['id' => $id], $input);

        return $individualEntrepreneur;
    }

    public function copy($ids): void
    {
        $individualEntrepreneurs = IndividualEntrepreneur::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($individualEntrepreneurs as $individualEntrepreneur) {
            $newManufacturer = $individualEntrepreneur->replicate();
            $newManufacturer->save();
        }
    }

    public function multiDelete($ids): void
    {
        IndividualEntrepreneur::whereIn('id', $ids)->delete();
    }
}

