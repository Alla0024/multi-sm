<?php

namespace App\Repositories;

use App\Models\PromoCodeGroup;
use App\Models\PromoCodeGroupDescription;
use App\Models\PromoCodeGroupToStore;
use App\Repositories\BaseRepository;

class PromoCodeGroupRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'status',
        'sort_order',
        'value',
        'change_number',
        'apply_immediately',
        'must_be_all_products',
        'type_number',
        'min_total_price',
        'min_product_price',
        'max_total_price',
        'max_product_price',
        'apply_for_products',
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
        return PromoCodeGroup::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $promoCodeGroup = $this->model
            ->with([
                'descriptions.language:id,code',
                'stores:id,name',
                'segments',
                'activatorSegments',
                'paymentMethods',
                'shippingMethods',
            ])
            ->find($id, $columns);

        if (!$promoCodeGroup) {
            return null;
        }

        $descriptions = $promoCodeGroup->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'name' => $desc->name,
                    'description' => $desc->description,
                    'title' => $desc->title,
                    'image' => $desc->image,
                ]
            ])
            ->toArray();

        return $promoCodeGroup
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

        $promoCodeGroups = $query->paginate($perPage);

        $promoCodeGroups->getCollection()->transform(function ($item) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);
            return $item;
        });

        return $promoCodeGroups;
    }

    public function save(array $input, ?int $id = null)
    {
        $stores = $input['stores'] ?? [];
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions'], $input['stores']);

        $promoCodeGroupSave = $input;

        $promoCodeGroup = $this->model->updateOrCreate(['id' => $id], $promoCodeGroupSave);

        foreach ($descriptions as $languageId => $descData) {
            PromoCodeGroupDescription::updateOrInsert(
                [
                    'promo_code_group_id' => (int)$promoCodeGroup->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        $stores && $promoCodeGroup->stores()->sync($stores);

        return $promoCodeGroup;
    }

    public function copy($ids): void
    {
        $promoCodeGroups = PromoCodeGroup::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($promoCodeGroups as $promoCodeGroup) {
            $newPromoCodeGroup = $promoCodeGroup->replicate();
            $newPromoCodeGroup->save();

            $stores = PromoCodeGroupToStore::where(['promo_code_group_id' => $promoCodeGroup->id])->get();

            foreach ($stores as $store) {
                $newStore = $store->toArray();
                $newStore['promo_code_group_id'] = $newPromoCodeGroup->id;
                PromoCodeGroupToStore::create($newStore);
            }

            foreach ($promoCodeGroup->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->promo_code_group_id = $newPromoCodeGroup->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        PromoCodeGroup::whereIn('id', $ids)->delete();
        PromoCodeGroupDescription::whereIn('promo_code_group_id', $ids)->delete();
    }
}
