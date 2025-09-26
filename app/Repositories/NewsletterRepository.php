<?php

namespace App\Repositories;

use App\Helpers\PictureHelper;
use App\Models\Newsletter;
use App\Repositories\BaseRepository;

class NewsletterRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'title',
        'type',
        'image',
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
        return Newsletter::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $newsletter = $this->model->find($id, $columns);

        if (!$newsletter) {
            return null;
        }

        $newsletter->setAttribute('authors', config('settings.message_authors'));
        $newsletter->setAttribute('types', config('settings.message_types'));

        return $newsletter;
    }

    public function filterRows(array $input)
    {
        $perPage = $input['perPage'] ?? 10;

        $query = $this->model::query();

        foreach (['type', 'status'] as $field) {
            $query->when($input[$field] ?? null, fn($q, $value) => $q->where($field, $value));
        }

        $query->when($input['sortBy'] ?? null, function ($q, $sortBy) {
            $sortMap = [
                'title_asc' => ['title', 'asc'],
                'title_desc' => ['title', 'desc'],
                'created_at_asc' => ['created_at', 'asc'],
                'created_at_desc' => ['created_at', 'desc'],
            ];

            if (isset($sortMap[$sortBy])) {
                [$column, $direction] = $sortMap[$sortBy];
                $q->orderBy($column, $direction);
            }
        });

        return $query->paginate($perPage);
    }


    public function save(array $input, ?int $id = null)
    {
        $newsletterSave = $input;

        if (!empty($input['image'])) {
            PictureHelper::noRewrite(
                $input['image'],
            );

            if (str_contains($input['image'], 'storage/images')) {
                $input['image'] = substr($input['image'], 15);
            }

            $newsletterSave['image'] = $input['image'];
        }

        return $this->model->updateOrCreate(['id' => $id], $newsletterSave);
    }

    public function copy($ids): void
    {
        $newsletters = Newsletter::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($newsletters as $newsletter) {
            $newNewsletter = $newsletter->replicate();
            $newNewsletter->save();
        }
    }

    public function multiDelete($ids): void
    {
        Newsletter::whereIn('id', $ids)->delete();
    }
}
