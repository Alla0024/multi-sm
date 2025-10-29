<?php

namespace App\Repositories;

use App\Helpers\PictureHelper;
use App\Models\BonusProgram;
use App\Models\BonusProgramDescription;
use App\Models\BonusProgramToStore;
use App\Models\FirstPathQuery;
use App\Repositories\BaseRepository;

class BonusProgramRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'hash',
        'type',
        'usage_percentage',
        'min_total_price',
        'color',
        'started_at',
        'finished_at',
        'priority'
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
                    'tag' => $desc->tag,
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

        unset($input['descriptions'], $input['path'], $input['stores']);

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
        }
    }

    public function multiDelete($ids): void
    {
        BonusProgram::whereIn('id', $ids)->delete();
        BonusProgramDescription::whereIn('bonus_program_id', $ids)->delete();
        FirstPathQuery::where('type', 'bonus_program')->whereIn('type_id', $ids)->delete();
    }
}

