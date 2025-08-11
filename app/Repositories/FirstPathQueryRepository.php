<?php

namespace App\Repositories;

use App\Models\FirstPathQuery;
use App\Repositories\BaseRepository;
use Exception;

class FirstPathQueryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'path'
    ];

    protected $additionalFields = [];

    /**
     * @throws Exception
     */
    private function validateType($type): string {
        return match ($type) {
            'category', 'bonus_program', 'news', 'authors', 'manufacturer', 'product', 'information', 'sale' => $type,
            default => throw new Exception("Type $type not exists"),
        };
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

    public function isThisPathExists(string $path, $exclude_id = null, $item_type = null): bool
    {
        $query = $this->model->where('path', $path);

        if (isset($item_type) && isset($exclude_id)) {
            $query->whereNot([
                ['type', '=', $item_type],
                ['type_id', '=', $exclude_id]
            ]);
        } else if (isset($exclude_id)) {
            $query->where('type_id', '<>', $exclude_id);
        }

        return $query->exists();
    }

    public function upsert($id, $type, $path)
    {
        $type = $this->validateType($type);

        $fist_path_query = $this->model->updateOrCreate(
            ['type' => $type, 'type_id' => $id],
            ['type' => $type, 'type_id' => $id, 'path' => $path]
        );

        return $fist_path_query;
    }

    public function destroy($id, $type) {
        return $this->model->where('type', $type)->where('type_id', $id)->delete();
    }
}
