<?php

namespace App\Repositories;

use App\Helpers\PictureHelper;
use App\Models\BonusProgram;
use App\Models\BonusProgramDescription;
use App\Models\BonusProgramToPaymentMethod;
use App\Models\BonusProgramToSegment;
use App\Models\BonusProgramToStore;
use App\Models\FirstPathQuery;
use App\Repositories\BaseRepository;

class BonusProgramRepository extends BaseRepository
{
    protected array $fieldSearchable = [

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
        return BonusProgram::class;
    }
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $bonusProgram = $this->model
            ->with([
                'descriptions.language:id,code',
                'seoPath:type_id,path',
                'stores:id,name',
                'segments',
                'paymentMethods'
            ])
            ->find($id, $columns);

        if (!$bonusProgram) {
            return null;
        }

        $descriptions = $bonusProgram->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'name' => $desc->name,
                    'description' => $desc->description,
                    'header' => $desc->header,
                    'mini_description' => $desc->mini_description,
                    'text' => $desc->text,
                    ]
            ])
            ->toArray();

        return $bonusProgram
            ->setRelation('descriptions', $descriptions)
            ->setAttribute('path', $bonusProgram->seoPath->path ?? '')
            ->makeHidden('seoPath');
    }

    public function filterRows(array $input)
    {
        $perPage    = $input['perPage'] ?? 10;
        $languageId = $input['language_id'] ?? config('settings.locale.default_language_id');

        $query = $this->model::with([
            'seoPath',
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

        $bonusPrograms = $query->paginate($perPage);

        $baseUrl = rtrim(config('app.client_url'), '/');
        $bonusPrograms->getCollection()->transform(function ($item) use ($baseUrl) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);
            $item->setAttribute(
                'client_url',
                $item->seoPath ? $baseUrl . '/' . ltrim($item->seoPath->path, '/') : null
            );
            return $item;
        });

        return $bonusPrograms;
    }

    public function save(array $input, ?int $id = null)
    {
        $seoPath = $input['path'] ?? null;
        $stores = $input['stores'] ?? [];
        $descriptions = $input['descriptions'] ?? [];
        $bonusProgramToPayment = $input['bonus_program_to_payment'] ?? [];
        $bonusProgramToSegment = $input['bonus_program_to_segment'] ?? [];

        unset(
            $input['descriptions'],
            $input['bonus_program_to_payment'],
            $input['bonus_program_to_payment'],
            $input['path'],
            $input['stores'],
        );

        $bonusProgram = $this->model->updateOrCreate(['id' => $id], $input);

        foreach ($descriptions as $languageId => $descData) {
            BonusProgramDescription::updateOrInsert(
                [
                    'bonus_program_id' => (int)$bonusProgram->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        $stores && $bonusProgram->stores()->sync($stores);

        $seoPath && FirstPathQuery::updateOrCreate(
            ['type' => 'bonus_program', 'type_id' => $bonusProgram->id],
            ['path' => $seoPath]
        );

        $syncRelated = function ($model, string $foreignKey, string $relatedKey, array $items) use ($bonusProgram) {
            $model::where($foreignKey, $bonusProgram->id)->delete();
            foreach ($items as $itemId) {
                $model::create([
                    $foreignKey => $bonusProgram->id,
                    $relatedKey => (int)$itemId
                ]);
            }
        };

        if (!empty($bonusProgramToPayment)) {
            $syncRelated(BonusProgramToPaymentMethod::class, 'bonus_program_id', 'payment_id', $bonusProgramToPayment);
        }

        if (!empty($bonusProgramToSegment)) {
            $syncRelated(BonusProgramToSegment::class, 'bonus_program_id', 'segment_id', $bonusProgramToSegment);
        }

        return $bonusProgram;
    }

    public function copy($ids): void
    {
        $bonusPrograms = BonusProgram::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($bonusPrograms as $bonusProgram) {
            $newBonusProgram = $bonusProgram->replicate();
            $newBonusProgram->save();

            $stores = BonusProgramToStore::where(['bonus_program_id' => $bonusProgram->id])->get();

            foreach ($stores as $store) {
                $newStore = $store->toArray();
                $newStore['bonus_program_id'] = $newBonusProgram->id;
                BonusProgramToStore::create($newStore);
            }

            foreach ($bonusProgram->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->bonus_program_id = $newBonusProgram->id;
                $newDescription->save();
            }

            $payments = BonusProgramToPaymentMethod::where('bonus_program_id', $bonusProgram->id)->get();
            foreach ($payments as $payment) {
                $newPayment = $payment->replicate();
                $newPayment->bonus_program_id = $newBonusProgram->id;
                $newPayment->save();
            }

            $segments = BonusProgramToSegment::where('bonus_program_id', $bonusProgram->id)->get();
            foreach ($segments as $segment) {
                $newSegment = $segment->replicate();
                $newSegment->bonus_program_id = $newBonusProgram->id;
                $newSegment->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        BonusProgram::whereIn('id', $ids)->delete();
        BonusProgramDescription::whereIn('bonus_program_id', $ids)->delete();
        BonusProgramToStore::whereIn('bonus_program_id', $ids)->delete();
        BonusProgramToPaymentMethod::whereIn('bonus_program_id', $ids)->delete();
        BonusProgramToSegment::whereIn('bonus_program_id', $ids)->delete();
        FirstPathQuery::where('type', 'bonus_program')->whereIn('type_id', $ids)->delete();
    }
}

