<?php

namespace App\Repositories;

use App\Models\PromoCodeGroup;
use App\Models\PromoCodeGroupDescription;
use App\Models\PromoCodeGroupToActivatorSegment;
use App\Models\PromoCodeGroupToPaymentMethod;
use App\Models\PromoCodeGroupToSegment;
use App\Models\PromoCodeGroupToShippingMethod;
use App\Models\PromoCodeGroupToStore;
use App\Models\SegmentDescription;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class PromoCodeGroupRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'status',
        'sort_order',
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
        $descriptions = $input['descriptions'] ?? [];
        $promoToPayment = $input['promo_to_payment'] ?? [];
        $promoToShipping = $input['promo_to_shipping'] ?? [];
        $promoToSegment = $input['promo_code_group_to_segment'] ?? [];
        $promoToActivatorSegment = $input['promo_code_group_to_activator_segment'] ?? [];

        unset(
            $input['descriptions'],
            $input['promo_to_payment'],
            $input['promo_to_shipping'],
            $input['promo_code_group_to_segment'],
            $input['promo_code_group_to_activator_segment']
        );

        $segment = $this->model->updateOrCreate(['id' => $id], $input);

        foreach ($descriptions as $languageId => $descData) {
            SegmentDescription::updateOrInsert(
                [
                    'segment_id' => (int)$segment->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        $syncRelated = function ($model, string $foreignKey, string $relatedKey, array $items) use ($segment) {
            $model::where($foreignKey, $segment->id)->delete();
            foreach ($items as $itemId) {
                $model::create([
                    $foreignKey => $segment->id,
                    $relatedKey => (int)$itemId
                ]);
            }
        };

        if (!empty($promoToPayment)) {
            $syncRelated(PromoCodeGroupToPaymentMethod::class, 'promo_code_group_id', 'payment_id', $promoToPayment);
        }

        if (!empty($promoToShipping)) {
            $syncRelated(PromoCodeGroupToShippingMethod::class, 'promo_code_group_id', 'shipping_id', $promoToShipping);
        }

        if (!empty($promoToSegment)) {
            $syncRelated(PromoCodeGroupToSegment::class, 'promo_code_group_id', 'segment_id', $promoToSegment);
        }

        if (!empty($promoToActivatorSegment)) {
            $syncRelated(PromoCodeGroupToActivatorSegment::class, 'promo_code_group_id', 'segment_id', $promoToActivatorSegment);
        }

        return $segment;
    }

    public function copy($ids): void
    {
        DB::transaction(function () use ($ids) {
            $promoCodeGroups = PromoCodeGroup::with(['descriptions'])->whereIn('id', $ids)->get();

            foreach ($promoCodeGroups as $promoCodeGroup) {
                $newPromoCodeGroup = $promoCodeGroup->replicate();
                $newPromoCodeGroup->status = 0;
                $newPromoCodeGroup->save();

                foreach ($promoCodeGroup->descriptions as $description) {
                    $newDescription = $description->replicate();
                    $newDescription->promo_code_group_id = $newPromoCodeGroup->id;
                    $newDescription->save();
                }

                $copyRelations = function ($model, string $foreignKey, int $oldId, int $newId) {
                    $relatedItems = $model::where($foreignKey, $oldId)->get();
                    foreach ($relatedItems as $item) {
                        $data = $item->toArray();
                        $data[$foreignKey] = $newId;
                        $model::create($data);
                    }
                };

                $copyRelations(PromoCodeGroupToStore::class, 'promo_code_group_id', $promoCodeGroup->id, $newPromoCodeGroup->id);
                $copyRelations(PromoCodeGroupToPaymentMethod::class, 'promo_code_group_id', $promoCodeGroup->id, $newPromoCodeGroup->id);
                $copyRelations(PromoCodeGroupToShippingMethod::class, 'promo_code_group_id', $promoCodeGroup->id, $newPromoCodeGroup->id);
                $copyRelations(PromoCodeGroupToSegment::class, 'promo_code_group_id', $promoCodeGroup->id, $newPromoCodeGroup->id);
                $copyRelations(PromoCodeGroupToActivatorSegment::class, 'promo_code_group_id', $promoCodeGroup->id, $newPromoCodeGroup->id);
            }
        });
    }

    public function multiDelete(array $ids): void
    {
        DB::transaction(function () use ($ids) {
            PromoCodeGroup::whereIn('id', $ids)->delete();
            PromoCodeGroupDescription::whereIn('promo_code_group_id', $ids)->delete();
            PromoCodeGroupToStore::whereIn('promo_code_group_id', $ids)->delete();
            PromoCodeGroupToPaymentMethod::whereIn('promo_code_group_id', $ids)->delete();
            PromoCodeGroupToShippingMethod::whereIn('promo_code_group_id', $ids)->delete();
            PromoCodeGroupToSegment::whereIn('promo_code_group_id', $ids)->delete();
            PromoCodeGroupToActivatorSegment::whereIn('promo_code_group_id', $ids)->delete();
        });
    }

}
