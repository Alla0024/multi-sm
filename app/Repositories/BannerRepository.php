<?php

namespace App\Repositories;

use App\Helpers\PictureHelper;
use App\Models\Banner;
use App\Models\BannerDescription;
use App\Repositories\BaseRepository;

class BannerRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'status',
        'banner_group_id',
        'sort_order',
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
        return Banner::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $banner = $this->model
            ->with([
                'descriptions.language:id,code',
            ])
            ->where('banner_group_id', $id)
            ->get($columns);

        if ($banner->isEmpty()) {
            return collect();
        }

        $descriptions = $banner->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'title' => $desc->title,
                    'image' => $desc->image,
                ]
            ])
            ->toArray();

        return $banner->setRelation('descriptions', $descriptions);
    }

    public function filterRows(array $input)
    {
        $perPage    = $input['perPage'] ?? 10;
        $languageId = $input['language_id'] ?? config('settings.locale.default_language_id');

        $query = $this->model::with([
            'descriptions' => fn($q) => $q->where('language_id', $languageId),
        ]);

        foreach (['sort_order', 'status'] as $field) {
            $query->when($input[$field] ?? null, fn($q, $value) => $q->where($field, $value));
        }

        $query->when($input['name'] ?? null, function ($q, $name) use ($languageId) {
            $q->whereHas('descriptions', function ($sub) use ($languageId, $name) {
                $sub->where('language_id', $languageId)
                    ->where('name', 'LIKE', "%{$name}%");
            });
        });

        $query->when($input['sortBy'] ?? null, function ($q, $sortBy) use ($languageId) {
            if (in_array($sortBy, ['name_asc', 'name_desc'])) {
                $q->withAggregate(
                    ['descriptions as name' => fn($sub) => $sub->where('language_id', $languageId)],
                    'name'
                )->orderBy('name', $sortBy === 'name_asc' ? 'asc' : 'desc');
            } elseif ($sortBy === 'created_at_asc') {
                $q->orderBy('created_at', 'asc');
            } elseif ($sortBy === 'created_at_desc') {
                $q->orderBy('created_at', 'desc');
            }
        });

        $banners = $query->paginate($perPage);

        $banners->getCollection()->transform(function ($item) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);
            return $item;
        });

        return $banners;
    }

    public function save(array $input, ?int $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];
        unset($input['descriptions']);

        $banner = $this->model->updateOrCreate(['id' => $id], $input);

        foreach ($descriptions as $languageId => $descData) {
            if (!empty($descData['image'])) {
                PictureHelper::rewrite(
                    $descData['image'],
                    config('settings.images.banner.width'),
                    config('settings.images.banner.height')
                );

                if (str_contains($descData['image'], 'storage/images')) {
                    $descData['image'] = substr($descData['image'], 15);
                }
            }

            BannerDescription::updateOrInsert(
                [
                    'banner_id' => $banner->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        return $banner;
    }


    public function copy($ids): void
    {
        $banners = Banner::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($banners as $banner) {
            $newBanner = $banner->replicate();
            $newBanner->save();

            foreach ($banner->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->banner_id = $newBanner->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        Banner::whereIn('id', $ids)->delete();
        BannerDescription::whereIn('banner_id', $ids)->delete();
    }
}
