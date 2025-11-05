<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Segment;
use App\Models\SegmentDescription;
use App\Models\SegmentToProduct;

class SegmentRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'status',
        'sort_order',
        'hash'
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
//                'segmentProducts'
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

    public function addProductsToSegment(int $segmentId, array $productIds): bool
    {
        foreach ($productIds as $productId) {
            SegmentToProduct::updateOrCreate([
                'segment_id' => $segmentId,
                'product_id' => $productId,
            ]);
        }

        return true;
    }

    public function removeProductsFromSegment(int $segmentId, array $productIds): bool
    {
        SegmentToProduct::where('segment_id', $segmentId)
            ->whereIn('product_id', $productIds)
            ->delete();

        return true;
    }

    public function addFilteredProductsToSegment(array $input, int $segmentId): bool
    {
        $productsQuery = Product::query()->with(['manufacturer', 'description', 'category', 'path']);
        $this->applyFilters($productsQuery, $input, $segmentId);

        $productIds = $productsQuery->pluck('id')->toArray();

        foreach (array_chunk($productIds, 100) as $batch) {
            foreach ($batch as $productId) {
                SegmentToProduct::updateOrCreate([
                    'segment_id' => $segmentId,
                    'product_id' => $productId,
                ]);
            }
        }

        return true;
    }

    public function removeFilteredProductsFromSegment(array $input, int $segmentId): bool
    {
        $productsQuery = Product::query()->with(['manufacturer', 'description', 'category', 'path']);
        $this->applyFilters($productsQuery, $input, $segmentId);

        $productIds = $productsQuery->pluck('id')->toArray();

        SegmentToProduct::where('segment_id', $segmentId)
            ->whereIn('product_id', $productIds)
            ->delete();

        return true;
    }

    private function applyFilters($query, array $input, int $segmentId): void
    {
        if (!empty($input['sort'])) {
            $query->orderBy($input['sort'], $input['order'] ?? 'asc');
        }

        foreach (['manufacturer_id', 'category_id', 'status', 'stock_status_id'] as $field) {
            if (!empty($input[$field]) && is_numeric($input[$field])) {
                $query->where($field, $input[$field]);
            }
        }

        if (isset($input['segment']) && is_numeric($input['segment'])) {
            $query->when($input['segment'] == 1, fn($q) =>
            $q->whereHas('product_in_segment', fn($s) => $s->where('segment_id', $segmentId))
            )->when($input['segment'] == 0, fn($q) =>
            $q->whereDoesntHave('product_in_segment', fn($s) => $s->where('segment_id', $segmentId))
            );
        }

        if (!empty($input['name'])) {
            $name = trim($input['name']);
            $query->whereHas('descriptions', fn($q) =>
            $q->where('name', 'LIKE', "%{$name}%")
            );
        }

        if (!empty($input['model'])) {
            $query->where('article', 'LIKE', "{$input['model']}%");
        }
    }
}

