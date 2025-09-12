<?php

namespace App\Repositories;

use App\Helpers\PictureHelper;
use App\Models\Category;
use App\Models\CategoryDescription;
use App\Models\FirstPathQuery;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'status'
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
        return Category::class;
    }

    public function with($relations)
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
                        ->where('name', 'LIKE', '%' . trim($args['q']) . '%');
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

    public function findFull($id, $columns = ['*'])
    {
        $category = $this->model
            ->with([
                'descriptions.language:id,code',
                'seoPath:type_id,path',
            ])
            ->find($id, $columns);

        if (!$category) {
            return null;
        }

        $descriptions = $category->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'name' => $desc->name,
                    'description' => $desc->description,
                    'tag' => $desc->tag,
                ]
            ])
            ->toArray();

        return $category
            ->setRelation('descriptions', $descriptions)
            ->setAttribute('path', $category->seoPath->path ?? '')
            ->makeHidden('seoPath');
    }

    public function filterRows($request)
    {
        $perPage = $request->integer('perPage', 10);
        $languageId = $request->input('language_id', config('settings.locale.default_language_id'));

        $query = $this->model::with([
            'seoPath',
            'descriptions' => function ($q) use ($languageId) {
                $q->where('language_id', $languageId);
            }
        ]);

        foreach (['sort_order', 'status'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->input($field));
            }
        }

        if ($request->filled('name')) {
            $name = mb_strtolower($request->input('name'), 'UTF-8');

            $query->whereHas('descriptions', function ($q) use ($name, $languageId) {
                $q->where('language_id', $languageId)
                    ->whereRaw('LOWER(name) LIKE ?', ["%{$name}%"]);
            });
        }

        if ($request->filled('sortBy')) {
            $sortBy = $request->input('sortBy');

            switch ($sortBy) {
                case 'name_asc':
                    $query->withAggregate(['descriptions as name' => fn($q) => $q->where('language_id', $languageId)], 'name')
                        ->orderBy('name', 'asc');
                    break;

                case 'name_desc':
                    $query->withAggregate(['descriptions as name' => fn($q) => $q->where('language_id', $languageId)], 'name')
                        ->orderBy('name', 'desc');
                    break;

                case 'created_at':
                    $query->orderBy('created_at', 'asc');
                    break;

                case 'created_at_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        $categories = $query->paginate($perPage);

        $baseUrl = config('app.client_url');
        $categories->getCollection()->transform(function ($item) use ($baseUrl) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);

            $item->setAttribute('client_url', $item->seoPath
                ? rtrim($baseUrl, '/') . '/' . ltrim($item->seoPath->path, '/')
                : null
            );

            return $item;
        });

        return $categories;
    }


    public function save(array $input, ?int $id = null)
    {
        $seoPath = $input['path'] ?? null;
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions'], $input['path'], $input['stores']);

        $categorySave = $input;

        if (!empty($input['image'])) {
            PictureHelper::rewrite(
                $input['image'],
                config('settings.images.category.width'),
                config('settings.images.category.height')
            );

            if (str_contains($input['image'], 'storage/images')) {
                $input['image'] = substr($input['image'], 15);
            }

            $categorySave['image'] = $input['image'];
        }

        $category = $this->model->updateOrCreate(['id' => $id], $categorySave);

        foreach ($descriptions as $languageId => $descData) {
            CategoryDescription::updateOrInsert(
                [
                    'category_id' => (int)$category->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        $seoPath && FirstPathQuery::updateOrCreate(
            ['type' => 'category', 'type_id' => $category->id],
            ['path' => $seoPath]
        );

        return $category;
    }

    public function copy($ids): void
    {
        $categories = Category::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($categories as $category) {
            $newCategory = $category->replicate();
            $newCategory->save();

            foreach ($category->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->category_id = $newCategory->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        Category::whereIn('id', $ids)->delete();
        CategoryDescription::whereIn('category_id', $ids)->delete();
        FirstPathQuery::where('type', 'category')->whereIn('type_id', $ids)->delete();
    }
}
