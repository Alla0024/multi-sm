<?php

namespace App\Repositories;

use App\Models\FirstPathQuery;
use App\Models\News;
use App\Models\NewsDescription;
use App\Repositories\BaseRepository;
use function Laravel\Prompts\select;

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

    public function getDetails($id, $language_id)
    {
        $news = $this->model->with([
            'descriptions',
            'seoPath' => function($query) {
                $query->select('type', 'type_id', 'path');
            },
            'author.descriptions' => function($query) use ($language_id) {
                $query->where('language_id', $language_id);
            },
            'category.descriptions' => function($query) use ($language_id) {
                $query->where('language_id', $language_id);
            },
            'newsCategories.descriptions' => function($query) use ($language_id) {
                $query->where('language_id', $language_id);
            },
        ])->find($id);

        $preshaped_descriptions = [];
        $preshaped_news_categories = [];
        $seo_path = $news->seoPath?->path;
        $category = $news->category->descriptions->first();
        $author = $news->author->descriptions->first();
        $preshaped_category = [ 'id' => $category->category_id, 'text' => $category->name ];
        $preshaped_author = [ 'id' => $author->author_id, 'name' => $author->name ];

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

        foreach ($news->newsCategories as $news_category) {
            $preshaped_news_categories[] = [
                'id' => $news_category->id,
                'text' => $news_category->descriptions->first()->name
            ];
        }

        unset(
            $news->seoPath,
            $news->category,
            $news->author,
        );
        $news->setAttribute('news_categories', $preshaped_news_categories);
        $news->setAttribute('category_id', $preshaped_category);
        $news->setAttribute('author_id', $preshaped_author);
        $news->setAttribute('descriptions', $preshaped_descriptions);
        $news->setAttribute('path', $seo_path);

        return $news;
    }

    public function filterIndexPage($perPage, $language_id, $params)
    {
        $news = $this->model
            ->leftJoin((new NewsDescription())->getTable() . " as nd", 'nd.news_id', '=', 'news.id')
            ->where('nd.language_id', $language_id)
            ->when(isset($params['sort_order']), function ($query) use ($params) {
                $query->where('sort_order', '=', $params['sort_order']);
            })
            ->when(isset($params['status']), function ($query) use ($params) {
                $query->where('status', '=', $params['status']);
            })
            ->when(isset($params['title']), function ($q) use ($params) {
                return $q->searchSimilarity(['nd.title'], $params['title']);
            })
            ->when(isset($params['sortBy']), function ($query) use ($params) {
                switch ($params['sortBy']) {
                    case 'name_asc':
                        $query->orderBy('nd.title', 'asc');
                        break;
                    case 'name_desc':
                        $query->orderBy('nd.title', 'desc');
                        break;
                    case 'created_at':
                        $query->orderBy('created_at', 'asc');
                        break;
                    case 'created_at_desc':
                        $query->orderBy('created_at', 'desc');
                        break;
                    default:
                        break;
                }

                return $query;
            })
            ->paginate($perPage, ['nd.title', 'sort_order', 'status', 'id', 'created_at', 'updated_at']);

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

        $firstPathQuery?->delete();
        $news->delete();
    }
}
