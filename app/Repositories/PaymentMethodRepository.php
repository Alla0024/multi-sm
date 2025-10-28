<?php

namespace App\Repositories;

use App\Models\PaymentMethod;
use App\Models\PaymentMethodDescription;
use App\Models\PaymentMethodToStore;
use App\Repositories\BaseRepository;

class PaymentMethodRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'code',
        'minimum',
        'icon',
        'status',
        'sort_order'
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
        return PaymentMethod::class;
    }
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $paymentMethod = $this->model
            ->with([
                'descriptions.language:id,code',
                'stores:id,name',
            ])
            ->find($id, $columns);

        if (!$paymentMethod ) {
            return null;
        }

        $descriptions = $paymentMethod->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'title' => $desc->title,
                    'comment' => $desc->comment,
                ]
            ])
            ->toArray();

        return $paymentMethod
            ->setRelation('descriptions', $descriptions);
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

        $paymentMethods = $query->paginate($perPage);

        $paymentMethods->getCollection()->transform(function ($item) {
            $item->setAttribute('title', optional($item->descriptions->first())->title);;
            return $item;
        });

        return $paymentMethods;
    }

    public function save(array $input, ?int $id = null)
    {
        $stores = $input['stores'] ?? [];
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions'], $input['stores']);

        $paymentMethodSave = $input;

        $paymentMethod = $this->model->updateOrCreate(['id' => $id], $paymentMethodSave);

        foreach ($descriptions as $languageId => $descData) {
            PaymentMethodDescription::updateOrInsert(
                [
                    'payment_method_id' => (int)$paymentMethod->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        $stores && $paymentMethod->stores()->sync($stores);

        return $paymentMethod;
    }

    public function copy($ids): void
    {
        $paymentMethods = PaymentMethod::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($paymentMethods as $paymentMethod) {
            $newPaymentMethod = $paymentMethod->replicate();
            $newPaymentMethod->save();

            $stores = PaymentMethodToStore::where(['payment_method_id' => $paymentMethod->id])->get();

            foreach ($stores as $store) {
                $newStore = $store->toArray();
                $newStore['payment_method_id'] = $newPaymentMethod->id;
                PaymentMethodToStore::create($newStore);
            }

            foreach ($paymentMethod->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->payment_method_id = $newPaymentMethod->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        PaymentMethod::whereIn('id', $ids)->delete();
        PaymentMethodDescription::whereIn('payment_method_id', $ids)->delete();
    }
}

