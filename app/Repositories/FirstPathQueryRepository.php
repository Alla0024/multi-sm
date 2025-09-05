<?php

namespace App\Repositories;

use App\Models\FirstPathQuery;

class FirstPathQueryRepository extends BaseRepository
{
    protected array $fieldSearchable = ['path'];

    protected array $additionalFields = [];

    protected array $validTypes = [
        'category', 'bonus_program', 'news', 'authors',
        'manufacturer', 'product', 'information', 'sale'
    ];

    public function rules(): array
    {
        return [
            'type' => 'required|string|in:' . implode(',', $this->validTypes),
            'type_id' => 'required|integer',
            'seo_url.*.path' => 'string|min:3|max:255|unique:first_path_queries,path,id'
        ];
    }

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
        return FirstPathQuery::class;
    }

    public function pathExists(string $path, ?int $excludeId = null, ?string $type = null): bool
    {
        return $this->model
            ->where('path', $path)
            ->when($excludeId !== null, fn($query) => $query->where('type_id', '<>', $excludeId))
            ->when($excludeId !== null && $type !== null, fn($query) => $query->where('type', '<>', $type))
            ->exists();
    }

    public function save(int $id, string $type, string $path)
    {
        return $this->model->updateOrCreate(
            ['type' => $type, 'type_id' => $id],
            ['path' => $path]
        );
    }

    public function destroy($id, $type)
    {
        return $this->model->where('type', $type)->where('type_id', $id)->delete();
    }
}
