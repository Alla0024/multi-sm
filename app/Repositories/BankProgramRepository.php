<?php

namespace App\Repositories;

use App\Models\BankProgram;
use App\Models\BankProgramDescription;
use App\Repositories\BaseRepository;

class BankProgramRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'mark',
        'bank_id',
        'logo',
        'sort_order',

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
        return BankProgram::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $bankProgram = $this->model
            ->with([
                'descriptions.language:id,code',
            ])
            ->find($id, $columns);

        if (!$bankProgram) {
            return null;
        }

        $descriptions = $bankProgram->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'name' => $desc->name,
                    'description' => $desc->description,
                    'tag' => $desc->tag,
                ]
            ])
            ->toArray();

        return $bankProgram
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

        $bankPrograms = $query->paginate($perPage);

        $bankPrograms->getCollection()->transform(function ($item) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);
            return $item;
        });

        return $bankPrograms;
    }

    public function save(array $input, ?int $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions']);

        $bankProgramSave = $input;

        $bankProgram = $this->model->updateOrCreate(['id' => $id], $bankProgramSave);

        foreach ($descriptions as $languageId => $descData) {
            BankProgramDescription::updateOrInsert(
                [
                    'bank_program_id' => (int)$bankProgram->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        return $bankProgram;
    }

    public function copy($ids): void
    {
        $bankPrograms = BankProgram::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($bankPrograms as $bankProgram) {
            $newBankProgram = $bankProgram->replicate();
            $newBankProgram->save();

            foreach ($bankProgram->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->bank_program_id = $newBankProgram->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        BankProgram::whereIn('id', $ids)->delete();
        BankProgramDescription::whereIn('bank_program_id', $ids)->delete();
    }
}
