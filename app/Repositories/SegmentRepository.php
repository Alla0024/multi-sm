<?php

namespace App\Repositories;

use App\Models\Segment;
use App\Models\SegmentDescription;

class SegmentRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'status',
        'hash',
        'sort_order'
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
        return Segment::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $segment = $this->model
            ->with([
                'descriptions.language:id,code',
            ])
            ->find($id, $columns);

        if (!$segment) {
            return null;
        }

        $descriptions = $segment->descriptions
            ->mapWithKeys(fn($desc) => [
                (string)($desc->language_id ?? $desc->language->code) => [
                    'name' => $desc->name,
                ]
            ])
            ->toArray();

        return $segment
            ->setRelation('descriptions', $descriptions);
    }

    public function filterRows(array $input)
    {
        $perPage = $input['perPage'] ?? 10;
        $languageId = $input['language_id'] ?? config('settings.locale.default_language_id');

        $query = $this->model::with([
            'descriptions' => fn($q) => $q->where('language_id', $languageId),
        ]);

        foreach (['sort_order', 'status'] as $field) {
            $query->when($input[$field] ?? null, fn($q, $value) => $q->where($field, $value));
        }

        $query->when($input['name'] ?? null, function ($q, $name) use ($languageId) {
            $q->whereHas('descriptions', function ($sub) use ($languageId, $name) {
                $sub->where('language_id', $languageId)
                    ->where('name', 'LIKE', "%{$name}%");
            });
        });

        $query->when($input['sortBy'] ?? null, function ($q, $sortBy) use ($languageId) {
            if (in_array($sortBy, ['name_asc', 'name_desc'])) {
                $q->withAggregate(
                    ['descriptions as name' => fn($sub) => $sub->where('language_id', $languageId)],
                    'name'
                )->orderBy('name', $sortBy === 'name_asc' ? 'asc' : 'desc');
            } elseif ($sortBy === 'created_at_asc') {
                $q->orderBy('created_at', 'asc');
            } elseif ($sortBy === 'created_at_desc') {
                $q->orderBy('created_at', 'desc');
            }
        });

        $segments = $query->paginate($perPage);

        $segments->getCollection()->transform(function ($item) {
            $item->setAttribute('name', optional($item->descriptions->first())->name);
            return $item;
        });

        return $segments;
    }

    public function save(array $input, ?int $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];

        unset($input['descriptions']);

        $segmentSave = $input;

        $segment = $this->model->updateOrCreate(['id' => $id], $segmentSave);

        foreach ($descriptions as $languageId => $descData) {
            SegmentDescription::updateOrInsert(
                [
                    'segment_id' => (int)$segment->id,
                    'language_id' => $languageId
                ],
                $descData
            );
        }

        return $segment;
    }

    public function copy($ids): void
    {
        $segments = Segment::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($segments as $segment) {
            $newSegment = $segment->replicate();
            $newSegment->save();

            foreach ($segment->descriptions as $description) {
                $newDescription = $description->replicate();
                $newDescription->segment_id = $newSegment->id;
                $newDescription->save();
            }
        }
    }

    public function multiDelete($ids): void
    {
        SegmentDescription::whereIn('segment_id', $ids)->delete();
        Segment::whereIn('id', $ids)->delete();
    }
}

