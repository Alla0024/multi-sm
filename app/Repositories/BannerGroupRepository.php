<?php

namespace App\Repositories;

use App\Models\Banner;
use App\Models\BannerGroup;
use App\Models\BannerGroupToStore;

class BannerGroupRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'name',
        'type',
        'layout',
        'width',
        'height',
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
        return BannerGroup::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $bannerGroup = $this->model
            ->with([
                'stores:id,name',
            ])
            ->find($id, $columns);

        if (!$bannerGroup) {
            return null;
        }


        return $bannerGroup;
    }

    public function filterRows(array $input)
    {
        $perPage    = $input['perPage'] ?? 10;

        $query = $this->model::with('banners');

        foreach (['banner_group_id', 'status'] as $field) {
            $query->when($input[$field] ?? null, fn($q, $value) => $q->where($field, $value));
        }

        if (!empty($input['name'])) {
            $query->where('name', 'LIKE', "%{$input['name']}%");
        }

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
        $stores = $input['stores'] ?? [];

        unset($input['stores']);

        $bannerGroupSave = $input;

        $bannerGroup = $this->model->updateOrCreate(['id' => $id], $bannerGroupSave);

        $stores && $bannerGroup->stores()->sync($stores);


        return $bannerGroup;
    }

    public function copy($ids): void
    {
        $bannerGroups = BannerGroup::whereIn('id', $ids)->get();

        foreach ($bannerGroups as $bannerGroup) {
            $newBannerGroup = $bannerGroup->replicate();
            $newBannerGroup->save();

            $stores = BannerGroupToStore::where(['banner_group_id' => $bannerGroup->id])->get();

            foreach ($stores as $store) {
                $newStore = $store->toArray();
                $newStore['banner_group_id'] = $newBannerGroup->id;
                BannerGroupToStore::create($newStore);
            }
        }
    }

    public function multiDelete($ids): void
    {
        BannerGroup::whereIn('id', $ids)->delete();
        Banner::whereIn('banner_group_id', $ids)->delete();
    }
}
