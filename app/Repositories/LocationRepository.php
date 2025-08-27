<?php

namespace App\Repositories;

use App\Models\Location;
use App\Repositories\BaseRepository;

class LocationRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'location_group_id',
        'type',
        'geocode',
        'path',
        'isocode',
        'hash',
        'ref',
        'indexing',
        'status',
        'delivery_file'
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
        return Location::class;
    }

    public function getDropdownItems($language_id, array $args): array
    {
        $locations = $this->model
            ->with([
                'descriptions' => function ($query) use ($language_id, $args) {
                    $query->where('language_id', $language_id)->select(['location_id', 'language_id', 'name']);
                }
            ]);

        if (isset($args['q'])) {
            if (is_numeric($args['q']) || preg_match('/^\s*[^,]+(\s*,\s*[^,]+)+\s*$/', $args['q'])) {
                if (is_array($args['q'])) {
                    $ids = $args['q'];
                } else {
                    $ids = explode(',', $args['q']);
                }

                $locations->whereIn('id', $ids);
            } else {
                $locations
                    ->whereHas('descriptions', function ($query) use ($args, $language_id) {
                        $query->where('language_id', $language_id)
                            ->searchSimilarity(['name'], $args['q']);
                    });
            }
        }

        $locations = $locations
            ->select(['id'])
            ->get();

        foreach ($locations as $product) {
            $result[] = [
                'id' => $product->id,
                'text' => $product->descriptions->first()->name
            ];
        }

        return $result ?? [];
    }
}
