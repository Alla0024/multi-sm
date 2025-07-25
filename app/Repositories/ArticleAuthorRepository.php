<?php

namespace App\Repositories;

use App\Models\ArticleAuthor;
use App\Models\FirstPathQuery;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class ArticleAuthorRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'date_of_birth',
        'facebook',
        'instagram'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return ArticleAuthor::class;
    }

    public function with($relations): Builder
    {
        return $this->model->with($relations);
    }

    public function create(array $input)
    {
        $seoUrl = $input['path'];
        unset($input['path']);

        $articleAuthor = $this->model->create($input);

        FirstPathQuery::create([
            'type' => 'authors',
            'type_id' => $articleAuthor->id,
            'path' => $seoUrl,
        ]);

        return $articleAuthor;
    }

    public function update(array $input, $id)
    {
        $seoUrl = $input['path'];
        unset($input['path']);

        $articleAuthor = $this->find($id);

        $firstPathQueryData = [
            'type' => 'authors',
            'type_id' => $id,
        ];

        $firstPathQuery = FirstPathQuery::where($firstPathQueryData)->first();

        if (!$firstPathQuery) {
            FirstPathQuery::create([
                ...$firstPathQueryData,
                'path' => $seoUrl,
            ]);
        } else {
            $firstPathQuery->update([
                'path' => $seoUrl,
            ]);
        }

        $articleAuthor->update($input);

        return $articleAuthor;
    }

}
