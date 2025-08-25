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

    protected $additionalFields = [
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
        return Category::class;
    }

    public function with($relations): Builder
    {
        return $this->model->with($relations);
    }

    public function getDropdownItems($language_id, $args = []): array
    {
        $items = $this->model
            ->with([
                'descriptions' => function ($query) use ($language_id) {
                    $query
                        ->where('language_id', $language_id)
                        ->select(['category_id', 'language_id', 'name']);
                }
            ])
            ->when(isset($args['q']), function ($query) use ($args, $language_id) {
                $query->whereHas('descriptions', function ($query) use ($args, $language_id) {
                    $query
                        ->where('language_id', $language_id)
                        ->searchSimilarity(['name'], $args['q']);
                });
            })
            ->get(['id']);


        foreach ($items as $item) {
            if ($item->id && $item->descriptions->first()?->name) {
                $result[] = [
                    "id" => $item->id,
                    "text" => $item->descriptions->first()->name,
                ];
            }
        }

        return $result ?? [];
    }
}
