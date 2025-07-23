<?php

namespace App\Repositories;

use App\Models\News;
use App\Models\NewsDescription;
use App\Repositories\BaseRepository;

class NewsRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'status',
        'reviews_count',
        'reviews_rating'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return News::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function create(array $input)
    {
        $descriptions = $input['descriptions'] ?? [];
        unset($input['descriptions']);

        $information = $this->model->create($input);

        foreach ($descriptions as $languageId => $descData) {
            $descData['language_id'] = $languageId;
            $descData['news_id'] = $information->id;
            NewsDescription::create($descData);
        }

        return $information;
    }

    public function update(array $input, $id)
    {
        $descriptions = $input['descriptions'] ?? [];
        unset($input['descriptions']);

        $news_category_id = $this->find($id);
        $news_category_id->update($input);

        foreach ($descriptions as $languageId => $descData) {
            NewsDescription::updateOrCreate(
                [
                    'news_id' => $news_category_id->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        return $news_category_id;
    }
}
