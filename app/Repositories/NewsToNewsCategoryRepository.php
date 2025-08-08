<?php

namespace App\Repositories;

use App\Models\NewsToNewsCategory;
use App\Repositories\BaseRepository;

class NewsToNewsCategoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return NewsToNewsCategory::class;
    }

    public function sync($news_id, array $news_category_ids): void
    {
        $this->model->where('news_id', $news_id)->delete();

        foreach ($news_category_ids as $category_id) {
            $this->model->create([
                'news_id' => $news_id,
                'news_category_id' => $category_id,
            ]);
        }
    }
}
