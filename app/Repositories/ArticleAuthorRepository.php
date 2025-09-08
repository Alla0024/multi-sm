<?php

namespace App\Repositories;

use App\Models\ArticleAuthor;
use App\Models\ArticleAuthorDescription;
use App\Models\FirstPathQuery;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Laracasts\Flash\Flash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleAuthorRepository extends BaseRepository
{
    protected $fieldSearchable = [
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
        return ArticleAuthor::class;
    }

    public function with($relations): Builder
    {
        return $this->model->with($relations);
    }

    public function getAuthorIdNameMap($language_id) {
        $authors = $this->model
            ->select('id')
            ->with(['descriptions' => function($query) {
                return $query->select('author_id', 'language_id', 'name');
            }])
            ->get();

        $result = [];

        foreach ($authors as $author) {
            $result[$author->id] = $author->descriptions->where('language_id', $language_id)->first()->name;
        }

        return $result;
    }

    public function find($id, $columns = ['*'])
    {
        $author = $this->model->with(['descriptions' => function ($query) {
            return $query->with('language');
        }])->find($id, $columns);

        $preshaped_descriptions = [];

        if (!empty($author)) {
            foreach ($author->descriptions as $description) {
                $preshaped_descriptions[$description->language->id] = [
                    'title' => $description->title,
                    'name' => $description->name,
                    'description' => $description->description,
                ];
            }
            unset($author->descriptions);
            $author->setAttribute('descriptions', $preshaped_descriptions);
        }

        $seoUrl = FirstPathQuery::where('type_id', $id)->where('type', 'authors')->value('path');;
        $author->setAttribute('path', $seoUrl);

        return $author;
    }

    public function filterIndexPage($request)
    {
        $params = $request->all();
        $perPage = $request->input('perPage', 10);
        $languageId = $request->get('language_id') ?? config('settings.locale.default_language_id');

        $authors = $this->model
            ->with(['descriptions' => function ($query) use ($languageId) {
                $query->select('author_id', 'language_id', 'name')
                    ->where('language_id', $languageId);
            }])
            ->when(isset($params['name']), function ($q) use ($params) {
                return $q->whereHas('descriptions', function ($q) use ($params) {
                    return $q->searchSimilarity(['name'], $params['name']);
                });
            })
            ->paginate($perPage);

        foreach ($authors as $author) {
            $name = $author->descriptions->first()->name ?? '';
            unset($author->descriptions);

            $author->setAttribute('name', $name);
        }

        return $authors;
    }

    public function create(array $input)
    {
        $descriptions = $input['descriptions'] ?? [];
        $seoPath = $input['path'];
        unset($input['descriptions'], $input['path']);

        $articleAuthor = $this->model->create($input);

        foreach ($descriptions as $languageId => $descData) {
            ArticleAuthorDescription::updateOrCreate(
                [
                    'author_id' => $articleAuthor->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        FirstPathQuery::create([
            'type' => 'authors',
            'type_id' => $articleAuthor->id,
            'path' => $seoPath,
        ]);

        return $articleAuthor;
    }

    public function update(array $input, $id)
    {
        $descriptions = $input['descriptions'] ?? [];
        $seoPath = $input['path'];
        unset($input['descriptions'], $input['path']);

        $author = $this->model->findOrFail($id);

        foreach ($descriptions as $languageId => $descData) {
            ArticleAuthorDescription::updateOrCreate(
                [
                    'author_id' => $id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        $firstPathQueryData = [
            'type' => 'authors',
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

        $author->update($input);
        return $author;
    }


    public function delete($id) {
        $articleAuthor = $this->find($id);

        $firstPathQuery = FirstPathQuery::where(['type' => 'authors', 'type_id' => $id ])->first();

        $firstPathQuery?->delete();
        $articleAuthor->delete();
    }

    public function getDropdownItems($language_id, $args): array
    {
        $items = $this->model
            ->with([
                'descriptions' => function ($query) use ($language_id) {
                    $query->where('language_id', $language_id)->select(["author_id", "language_id", "name"]);
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

        $result = [];

        foreach ($items as $item) {
            $result[] = [
                "id" => $item->id,
                "text" => optional($item->descriptions->first())->name ?? '',
            ];
        }

        return $result ?? [];
    }
}
