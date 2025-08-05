<?php

namespace App\Repositories;

use App\Models\NewsCategory;
use App\Models\NewsCategoryDescription;
use App\Repositories\BaseRepository;

class NewsCategoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'status',
        'seo_url',
        'sort_order'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return NewsCategory::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function filterIndexPage($id, $params)
    {
        $news = $this->model
            ->with(['descriptions'])
            ->when(isset($params['sort_order']), function ($query) use ($params) {
                $query->where('sort_order', '=', $params['sort_order']);
            })
            ->when(isset($params['status']), function ($query) use ($params) {
                $query->where('status', '=', $params['status']);
            })
            ->when(isset($params['name']), function ($q) use ($params) {
                return $q->whereHas('descriptions', function ($q) use ($params) {
                    return $q->searchSimilarity(['name'], $params['name']);
                });
            })
            ->find($id);

        $preshaped_descriptions = [];

        foreach ($news->descriptions as $description) {
            $preshaped_descriptions[$description->language->id] = [
                'name' => $description->name,
            ];
        }
        unset($news->descriptions);
        $news->setAttribute('descriptions', $preshaped_descriptions);

        return $news;
    }

    public function create(array $input)
    {
        $descriptions = $input['descriptions'] ?? [];
        unset($input['descriptions']);

        $information = $this->model->create($input);

        foreach ($descriptions as $languageId => $descData) {
            $descData['language_id'] = $languageId;
            $descData['news_category_id'] = $information->id;
            NewsCategoryDescription::create($descData);
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
            NewsCategoryDescription::updateOrCreate(
                [
                    'news_category_id' => $news_category_id->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        return $news_category_id;
    }

    public function getDropdownItems($language_id, $args): array
    {
        $items = $this->model
            ->with([
                'descriptions' => function ($query) use ($language_id) {
                    $query->where('language_id', $language_id)->select(["news_category_id", "language_id", "name"]);
                }
            ])
            ->when(isset($args['q']) && $args['q'] !== null, function ($query) use ($args, $language_id) {
                $query->whereHas('descriptions', function ($query) use ($args, $language_id) {
                    $query
                        ->where('language_id', $language_id)
                        ->searchSimilarity(['name'], $args['q']);;
                });
            })
            ->get(['id']);

        foreach ($items as $item) {
            $result[] = [
                "id" => $item->id,
                "text" => $item->descriptions->first()->name,
            ];
        }


        return $result ?? [];
    }
}
