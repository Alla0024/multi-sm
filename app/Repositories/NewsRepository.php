<?php

namespace App\Repositories;

use App\Models\FirstPathQuery;
use App\Models\News;
use App\Models\NewsDescription;
use App\Repositories\BaseRepository;

class NewsRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'sort_order',
        'status'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return News::class;
    }

    public function paginateIndexPage($perPage, $language_id, $columns = ['*'])
    {
        $news = $this->model
            ->with(['descriptions' => function ($query) use ($language_id) {
                return $query
                    ->select('news_id', 'language_id', 'title')
                    ->where('language_id', $language_id);
            }])
            ->paginate($perPage, $columns);

        foreach ($news as $item) {
            $title = $item->descriptions->first()->title;
            unset($item->descriptions);

            $item->setAttribute('title', $title);
        }

        return $news;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function create(array $input)
    {
        $descriptions = $input['descriptions'] ?? [];
        $seoPath = $input['path'];
        unset($input['descriptions'], $input['path']);

        $information = $this->model->create($input);

        foreach ($descriptions as $languageId => $descData) {
            $descData['language_id'] = $languageId;
            $descData['news_id'] = $information->id;
            NewsDescription::create($descData);
        }

        $firstPathQuery = FirstPathQuery::create([
            'type' => 'news',
            'type_id' => $information->id,
            'path' => $seoPath,
        ]);

        return $information;
    }

    public function update(array $input, $id)
    {
        $descriptions = $input['descriptions'] ?? [];
        unset($input['descriptions']);

        $seoPath = $input['path'];
        unset($input['path']);

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

        $firstPathQueryData = [
            'type' => 'news',
            'type_id' => $id,
        ];

        $firstPathQuery = FirstPathQuery::where($firstPathQueryData)->first();

        if (!$firstPathQuery) {
            FirstPathQuery::create([
                ...$firstPathQueryData,
                'path' => $seoPath,
            ]);
        } else {
            $firstPathQuery->update([
                'path' => $seoPath,
            ]);
        }

        return $news_category_id;
    }

    public function delete($id) {
        $news = $this->find($id);

        $firstPathQuery = FirstPathQuery::where(['type' => 'news', 'type_id' => $id ])->first();

        if (!$firstPathQuery) {
            throw new \Error('First path query not found.');
        }

        $firstPathQuery->delete();
        $news->delete();
    }
}
