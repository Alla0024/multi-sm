<?php

namespace App\Repositories;

use App\Helpers\PictureHelper;
use App\Models\AttributeWord;
use App\Models\AttributeWordDescription;
use App\Repositories\BaseRepository;

class AttributeWordRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'sort_order',
        'key'
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
        return AttributeWord::class;
    }
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $attributeWord = $this->model
            ->with([
                'descriptions.language:id,code',
            ])
            ->find($id, $columns);

        if (!$attributeWord) {
            return null;
        }

        $descriptions = $attributeWord->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->lang_id ?? $desc->language->code) => [
                    'word' => $desc->word,
                    'description' => $desc->description,
                ]
            ])
            ->toArray();

        return $attributeWord
            ->setRelation('descriptions', $descriptions);
    }

    public function filterRows($request)
    {
        $perPage = $request->integer('perPage', 10);
        $languageId = $request->input('lang_id', config('settings.locale.default_language_id'));

        $query = $this->model::with([
            'descriptions' => function ($q) use ($languageId) {
                $q->where('lang_id', $languageId);
            }
        ]);

        foreach (['sort_order', 'key'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->input($field));
            }
        }

        if ($request->filled('word')) {
            $word = mb_strtolower($request->input('word'), 'UTF-8');

            $query->whereHas('descriptions', function ($q) use ($word, $languageId) {
                $q->where('lang_id', $languageId)
                    ->whereRaw('LOWER(word) LIKE ?', ["%{$word}%"]);
            });
        }

        if ($request->filled('sortBy')) {
            $sortBy = $request->input('sortBy');

            switch ($sortBy) {
                case 'word_asc':
                    $query->withAggregate(['descriptions as word' => fn($q) => $q->where('lang_id', $languageId)], 'word')
                        ->orderBy('word', 'asc');
                    break;

                case 'word_desc':
                    $query->withAggregate(['descriptions as word' => fn($q) => $q->where('lang_id', $languageId)], 'word')
                        ->orderBy('word', 'desc');
                    break;

                case 'created_at':
                    $query->orderBy('created_at', 'asc');
                    break;

                case 'created_at_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        $attributeWords = $query->paginate($perPage);

        $attributeWords->getCollection()->transform(function ($item) {
            $item->setAttribute('word', optional($item->descriptions->first())->word);

            return $item;
        });

        return $attributeWords;
    }


    public function save(array $input, ?int $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions']);

        $attributeWordSave = $input;

        $attributeWord = $this->model->updateOrCreate(['id' => $id], $attributeWordSave);

        foreach ($descriptions as $languageId => $descData) {
            AttributeWordDescription::updateOrInsert(
                [
                    'attribute_word_id' => (int)$attributeWord->id,
                    'lang_id' => $languageId
                ],
                $descData
            );
        }

        return $attributeWord;
    }

    public function copy($ids): void
    {
        $attributeWords = AttributeWord::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($attributeWords as $attributeWord) {
            $newAttributeWord = $attributeWord->replicate();
            $attributeWord->save();

            foreach ($attributeWord->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->attribute_word_id = $newAttributeWord->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        AttributeWord::whereIn('id', $ids)->delete();
        AttributeWordDescription::whereIn('attribute_word_id', $ids)->delete();
    }
}

