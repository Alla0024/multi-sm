<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class CategoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'image',
        'full_image',
        'icon',
        'parent_id',
        'sub',
        'sort_order',
        'status'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Category::class;
    }

    public function with($relations): Builder
    {
        return $this->model->with($relations);
    }

    public function getIdNameMap($language_id): array
    {
        $items = $this->model
            ->with([
                'descriptions' => function ($query) use ($language_id) {
                    $query->where('language_id', $language_id)->select(["category_id", "language_id", "name"]);
                }
            ])
            ->get(['id']);

        foreach ($items as $item) {
            $result[] = [
                "id" => $item->id,
                "text" => $item->descriptions[0]->name,
            ];
        }

        return $result ?? [];
    }
}
