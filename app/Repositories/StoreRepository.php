<?php

namespace App\Repositories;

use App\Models\Store;
use App\Repositories\BaseRepository;

class StoreRepository extends BaseRepository
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
        return Store::class;
    }

    public function getDropdownItems($language_id, $args): array
    {
        $items = $this->model
            ->when(isset($args['q']), function ($query) use ($args, $language_id) {
                $query->where('language_id', $language_id)
                    ->searchSimilarity(['name'], $args['q']);
            })
            ->get(['id', 'name']);

        $result = [];

        foreach ($items as $item) {
            $result[] = [
                "id" => $item->id,
                "text" => $item->name,
            ];
        }

        return $result ?? [];
    }
}
