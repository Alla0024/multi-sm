<?php

namespace App\Repositories;

use App\Models\PromoCode;
use App\Models\PromoCodeDescription;
use App\Repositories\BaseRepository;

class PromoCodeRepository extends BaseRepository
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
        return PromoCode::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $promoCode = $this->model
            ->with([
                'descriptions.language:id,code',
                'promoCodeGroup'
            ])
            ->find($id, $columns);

        if (!$promoCode) {
            return null;
        }

        $descriptions = $promoCode->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'name' => $desc->name,
                    'description' => $desc->description,
                    'title' => $desc->title,
                    'image' => $desc->image,
                ]
            ])
            ->toArray();

        return $promoCode
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

        $promoCodes = $query->paginate($perPage);

        $promoCodes->getCollection()->transform(function ($item) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);
            return $item;
        });

        return $promoCodes;
    }

    public function save(array $input, ?int $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions']);

        $promoCodeSave = $input;

        $promoCode = $this->model->updateOrCreate(['id' => $id], $promoCodeSave);

        foreach ($descriptions as $languageId => $descData) {
            PromoCodeDescription::updateOrInsert(
                [
                    'promo_code_id' => (int)$promoCode->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        return $promoCode;
    }

    public function copy($ids): void
    {
        $promoCodes = PromoCode::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($promoCodes as $promoCode) {
            $newPromoCode = $promoCode->replicate();
            $newPromoCode->save();

            foreach ($promoCode->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->promo_code_id = $newPromoCode->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        PromoCode::whereIn('id', $ids)->delete();
        PromoCodeDescription::whereIn('promo_code_id', $ids)->delete();
    }
}

