<?php

namespace App\Repositories;

use App\Helpers\PictureHelper;
use App\Models\Shop;
use App\Models\ShopDescription;
use App\Models\ShopImage;
use App\Repositories\BaseRepository;

class ShopRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'fake_status',
        'status',
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
        return Shop::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $shop = $this->model
            ->with([
                'descriptions.language:id,code',
                'shopImages',
            ])
            ->find($id, $columns);

        if (!$shop) {
            return null;
        }

        $descriptions = $shop->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'name' => $desc->name,
                    'address' => $desc->address,
                    'schedule' => $desc->schedule,
                    'schedule_temporary' => $desc->schedule_temporary,
                    'description' => $desc->description,
                    'sale' => $desc->sale,
                    'image_banner' => $desc->image_banner,
                ]
            ])
            ->toArray();

        return $shop
            ->setRelation('descriptions', $descriptions);
    }

    public function filterRows(array $input)
    {
        $perPage = $input['perPage'] ?? 10;
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

        $shops = $query->paginate($perPage);

        $shops->getCollection()->transform(function ($item) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);
            return $item;
        });

        return $shops;
    }

    public function save(array $input, ?int $id = null)
    {
        $stores = $input['stores'] ?? [];
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions']);

        $shopSave = $input;
        if (!empty($input['image'])) {
            $shopSave['image'] = PictureHelper::process(
                $input['image'],
                config('settings.images.shop.list.width'),
                config('settings.images.shop.list.height')
            );
        }

        $shop = $this->model->updateOrCreate(['id' => $id], $shopSave);

        foreach ($descriptions as $languageId => $descData) {
            if (!empty($descData['image_banner'])) {
                $descData['image_banner'] = PictureHelper::process(
                    $descData['image_banner'],
                    config('settings.images.shop.banner.width'),
                    config('settings.images.shop.banner.height')
                );
            }

            ShopDescription::updateOrInsert(
                [
                    'shop_id' => (int)$shop->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        if (!empty($images)) {
            ShopImage::where('shop_id', $shop->id)->delete();

            $first = true;
            foreach ($images as $image) {
                $shopImage = new ShopImage();
                $shopImage->shop_id = $shop->id;
                $shopImage->sort_order = $image['sort_order'] ?? 0;

                if (!empty($image['image'])) {
                    if ($first) {
                        $processed = PictureHelper::process(
                            $image['image'],
                            config('settings.images.shop.first_image.width'),
                            config('settings.images.shop.first_image.height'),
                            true
                        );
                        $first = false;
                    } else {
                        $processed = PictureHelper::process(
                            $image['image'],
                            config('settings.images.shop.images.width'),
                            config('settings.images.shop.images.height'),
                            true
                        );
                    }

                    $shopImage->image = $processed;
                } else {
                    $shopImage->image = '';
                }

                $shopImage->save();
            }
        }

        $stores && $shop->stores()->sync($stores);

        return $shop;
    }

    public function copy($ids): void
    {
        $shops = Shop::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($shops as $shop) {
            $newShop = $shop->replicate();
            $newShop->save();

            foreach ($shop->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->shop_id = $newShop->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        Shop::whereIn('id', $ids)->delete();
        ShopDescription::whereIn('shop_id', $ids)->delete();
    }
}
