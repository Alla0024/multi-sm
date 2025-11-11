<?php

namespace App\Repositories;

use App\Models\Postcode;
use Illuminate\Support\Facades\DB;

class PostcodeRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'status',
        'postcode',
        'city_id',
        'province_id',
        'municipality_id',
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
        return Postcode::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        return $this->model
            ->with([
//                'city:id,name',
//                'province:id,name',
//                'municipality:id,name',
            ])
            ->find($id, $columns);
    }

    public function filterRows(array $input)
    {
        $perPage = $input['perPage'] ?? 10;

        $query = $this->model::with([
//            'city',
//            'province',
//            'municipality',
        ]);

        if (!empty($input['status'])) {
            $query->where('status', $input['status']);
        }

        if (!empty($input['postcode'])) {
            $query->where('postcode', 'LIKE', '%' . $input['postcode'] . '%');
        }

        if (!empty($input['sortBy'])) {
            switch ($input['sortBy']) {
                case 'postcode_asc':
                    $query->orderBy('postcode', 'asc');
                    break;
                case 'postcode_desc':
                    $query->orderBy('postcode', 'desc');
                    break;
                case 'created_at_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'created_at_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        return $query->paginate($perPage);
    }

    public function save(array $input, ?int $id = null): Postcode
    {
        return DB::transaction(function () use ($input, $id) {
            $postcode = $id
                ? $this->model->findOrFail($id)
                : new Postcode();

            $postcode->fill($input);
            $postcode->save();

            return $postcode;
        });
    }

    public function copy(array $ids): void
    {
        DB::transaction(function () use ($ids) {
            $postcodes = Postcode::whereIn('id', $ids)->get();

            foreach ($postcodes as $postcode) {
                $newPostcode = $postcode->replicate();
                $newPostcode->status = 0;
                $newPostcode->created_at = now();
                $newPostcode->updated_at = now();
                $newPostcode->save();
            }
        });
    }

    public function multiDelete(array $ids): void
    {
        Postcode::whereIn('id', $ids)->delete();
    }
}
