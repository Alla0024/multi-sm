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

    public function find($id, $columns = ['*'])
    {
        $news = $this->model
            ->with([
                'seoPath',
                'descriptions' =>
                    function ($query) {
                        return $query->with('language');
                    }
                ]
            )->find($id, $columns);

        $preshaped_descriptions = [];

        foreach ($news->descriptions as $description) {
            $preshaped_descriptions[$description->language->id] = [
                'title' => $description->title,
                'description' => $description->description,
                'meta_h1' => $description->meta_h1,
                'meta_title' => $description->meta_title,
                'meta_description' => $description->meta_description,
                'meta_keyword' => $description->meta_keyword,
                'products_title' => $description->products_title,
            ];
        }
        unset($news->descriptions);
        $news->setAttribute('descriptions', $preshaped_descriptions);
        $news->setAttribute('path', $news->seoPath->path);

        return $news;
    }

    public function paginateIndexPage($perPage, $language_id, $params)
    {
        $news = $this->model
            ->with(['descriptions' => function ($query) use ($language_id) {
                $query->select('news_id', 'language_id', 'title')
                    ->where('language_id', $language_id);
            }])
            ->when(isset($params['title']), function ($q) use ($params) {
                return $q->whereHas('descriptions', function ($q) use ($params) {
                    return $q->searchSimilarity(['title'], $params['title']);
                });
            })
            ->paginate($perPage);



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

        $news = $this->model->create($input);

        foreach ($descriptions as $languageId => $descData) {
            NewsDescription::updateOrCreate(
                [
                    'news_id' => $news->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }
        $firstPathQuery = FirstPathQuery::create([
            'type' => 'news',
            'type_id' => $news->id,
            'path' => $seoPath,
        ]);

        return $news;
    }

    public function update(array $input, $id)
    {
        $descriptions = $input['descriptions'] ?? [];
        unset($input['descriptions']);

        $seoPath = $input['path'];
        unset($input['path']);

        $news = $this->model->find($id);
        $news->update($input);

        foreach ($descriptions as $languageId => $descData) {
            NewsDescription::updateOrCreate(
                [
                    'news_id' => $id,
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

        return $news;
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
