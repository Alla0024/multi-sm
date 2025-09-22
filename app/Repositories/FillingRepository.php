<?php

namespace App\Repositories;

use App\Helpers\PictureHelper;
use App\Models\Filling;
use App\Models\FillingDescription;
use App\Models\FirstPathQuery;

class FillingRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'sort_order',
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
        return Filling::class;
    }
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $filling = $this->model
            ->with([
                'descriptions.language:id,code',
            ])
            ->find($id, $columns);

        if (!$filling) {
            return null;
        }

        $descriptions = $filling->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'title' => $desc->title,
                    'header' => $desc->header,
                    'description' => $desc->description,
                ]
            ])
            ->toArray();

        return $filling
            ->setRelation('descriptions', $descriptions);
    }

    public function filterRows($request)
    {
        $perPage = $request->integer('perPage', 10);
        $languageId = $request->input('language_id', config('settings.locale.default_language_id'));

        $query = $this->model::with([
            'descriptions' => function ($q) use ($languageId) {
                $q->where('language_id', $languageId);
            }
        ]);

        foreach (['sort_order', 'status'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->input($field));
            }
        }

        if ($request->filled('title')) {
            $title = mb_strtolower($request->input('title'), 'UTF-8');

            $query->whereHas('descriptions', function ($q) use ($title, $languageId) {
                $q->where('language_id', $languageId)
                    ->whereRaw('LOWER(title) LIKE ?', ["%{$title}%"]);
            });
        }

        if ($request->filled('sortBy')) {
            $sortBy = $request->input('sortBy');

            switch ($sortBy) {
                case 'title_asc':
                    $query->withAggregate(['descriptions as title' => fn($q) => $q->where('language_id', $languageId)], 'title')
                        ->orderBy('title', 'asc');
                    break;

                case 'title_desc':
                    $query->withAggregate(['descriptions as title' => fn($q) => $q->where('language_id', $languageId)], 'title')
                        ->orderBy('title', 'desc');
                    break;

                case 'created_at':
                    $query->orderBy('created_at', 'asc');
                    break;

                case 'created_at_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        $fillings = $query->paginate($perPage);

        $fillings->getCollection()->transform(function ($item) {
            $item->setAttribute('title', optional($item->descriptions->first())->title);

            return $item;
        });

        return $fillings;
    }


    public function save(array $input, ?int $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions'], $input['path'], $input['stores']);

        $fillingSave = $input;

        if (!empty($input['image'])) {
            PictureHelper::rewrite(
                $input['image'],
                config('settings.images.filling.width'),
                config('settings.images.filling.height')
            );

            if (str_contains($input['image'], 'storage/images')) {
                $input['image'] = substr($input['image'], 15);
            }

            $fillingSave['image'] = $input['image'];
        }

        $filling = $this->model->updateOrCreate(['id' => $id], $fillingSave);

        foreach ($descriptions as $languageId => $descData) {
            FillingDescription::updateOrInsert(
                [
                    'filling_id' => (int)$filling->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        return $filling;
    }

    public function copy($ids): void
    {
        $fillings = Filling::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($fillings as $filling) {
            $newFilling = $filling->replicate();
            $newFilling->save();

            foreach ($filling->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->filling_id = $newFilling->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        Filling::whereIn('id', $ids)->delete();
        FillingDescription::whereIn('filling_id', $ids)->delete();
        FirstPathQuery::where('type', 'filling')->whereIn('type_id', $ids)->delete();
    }
}

