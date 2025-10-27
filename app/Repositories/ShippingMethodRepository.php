<?php

namespace App\Repositories;

use App\Models\ShippingMethod;
use App\Models\ShippingMethodDescription;
use App\Models\ShippingMethodToStore;

class ShippingMethodRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'minimum',
        'maximum',
        'depend',
        'value',
        'type',
        'status',
        'sort_order',
        'start_date',
        'end_date'
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
        return ShippingMethod::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $shippingMethod = $this->model
            ->with([
                'descriptions.language:id,code',
                'stores:id,name',
            ])
            ->find($id, $columns);

        if (!$shippingMethod) {
            return null;
        }

        $descriptions = $shippingMethod->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'title' => $desc->title,
                    'comment' => $desc->comment,
                    'condition' => $desc->condition,
                ]
            ])
            ->toArray();

        return $shippingMethod
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

        $query->when($input['title'] ?? null, function ($q, $title) use ($languageId) {
            $q->whereHas('descriptions', function ($sub) use ($languageId, $title) {
                $sub->where('language_id', $languageId)
                    ->where('title', 'LIKE', "%{$title}%");
            });
        });

        $query->when($input['sortBy'] ?? null, function ($q, $sortBy) use ($languageId) {
            if (in_array($sortBy, ['title_asc', 'title_desc'])) {
                $q->withAggregate(
                    ['descriptions as title' => fn($sub) => $sub->where('language_id', $languageId)],
                    'title'
                )->orderBy('title', $sortBy === 'title_asc' ? 'asc' : 'desc');
            } elseif ($sortBy === 'created_at_asc') {
                $q->orderBy('created_at', 'asc');
            } elseif ($sortBy === 'created_at_desc') {
                $q->orderBy('created_at', 'desc');
            }
        });

        $shippingMethods = $query->paginate($perPage);

        $shippingMethods->getCollection()->transform(function ($item) {
            $item->setAttribute('title', optional($item->descriptions->first())->title);
            return $item;
        });

        return $shippingMethods;
    }

    public function save(array $input, ?int $id = null)
    {
        $stores = $input['stores'] ?? [];
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions'], $input['stores']);

        $shippingMethodSave = $input;


        $shippingMethod = $this->model->updateOrCreate(['id' => $id], $shippingMethodSave);

        foreach ($descriptions as $languageId => $descData) {
            ShippingMethodDescription::updateOrInsert(
                [
                    'shipping_method_id' => (int)$shippingMethod->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        $stores && $shippingMethod->stores()->sync($stores);


        return $shippingMethod;
    }

    public function copy($ids): void
    {
        $shippingMethods = ShippingMethod::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($shippingMethods as $shippingMethod) {
            $newShippingMethod = $shippingMethod->replicate();
            $newShippingMethod->save();

            $stores = ShippingMethodToStore::where(['shipping_method_id' => $shippingMethod->id])->get();

            foreach ($stores as $store) {
                $newStore = $store->toArray();
                $newStore['shipping_method_id'] = $newShippingMethod->id;
                ShippingMethodToStore::create($newStore);
            }

            foreach ($shippingMethod->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->shipping_method_id = $newShippingMethod->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        ShippingMethod::whereIn('id', $ids)->delete();
        ShippingMethodDescription::whereIn('shipping_method_id', $ids)->delete();
    }
}
