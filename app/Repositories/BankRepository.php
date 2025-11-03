<?php

namespace App\Repositories;

use App\Models\Bank;
use App\Models\BankDescription;
use App\Repositories\BaseRepository;

class BankRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'mark',
        'logo',
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
        return Bank::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $bank = $this->model
            ->with([
                'descriptions.language:id,code',
            ])
            ->find($id, $columns);

        if (!$bank) {
            return null;
        }

        $descriptions = $bank->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'name' => $desc->name,
                    'note' => $desc->note,
                ]
            ])
            ->toArray();

        return $bank
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

        $banks = $query->paginate($perPage);

        $banks->getCollection()->transform(function ($item) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);
            return $item;
        });

        return $banks;
    }

    public function save(array $input, ?int $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions']);

        $bankSave = $input;

        $bank = $this->model->updateOrCreate(['id' => $id], $bankSave);

        foreach ($descriptions as $languageId => $descData) {
            BankDescription::updateOrInsert(
                [
                    'bank_id' => (int)$bank->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        return $bank;
    }

    public function copy($ids): void
    {
        $banks = Bank::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($banks as $bank) {
            $newBank = $bank->replicate();
            $newBank->save();

            foreach ($bank->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->bank_id = $newBank->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        Bank::whereIn('id', $ids)->delete();
        BankDescription::whereIn('bank_id', $ids)->delete();
    }
}

