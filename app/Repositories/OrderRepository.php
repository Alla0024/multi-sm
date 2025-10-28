<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'surname',
        'name',
        'email',
        'phone',
        'address',
        'comment',
        'location_group_id',
        'location_id',
        'ref_settlement',
        'payment_method_id',
        'payment_method_comment',
        'shipping_method_id',
        'shipping_method_comment',
        'serialized_data',
        'client_id',
        'total',
        'promo_sum',
        'order_status',
        'status_from_1c',
        'order_user_id',
        'lead_id',
        'ip',
        'user_agent'
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
        return Order::class;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function findFull($id, $columns = ['*'])
    {
        $order = $this->model
            ->find($id, $columns);

        if (!$order) {
            return null;
        }

        return $order;
    }

    public function filterRows(array $input)
    {
        $perPage = $input['perPage'] ?? 10;
        $query = $this->model;

        foreach (['sort_order', 'status'] as $field) {
            $query->when($input[$field] ?? null, fn($q, $value) => $q->where($field, $value));
        }

        return $query->paginate($perPage);
    }

    public function save(array $input, ?int $id = null)
    {
        return $this->model->updateOrCreate(['id' => $id], $input);
    }

    public function copy($ids): void
    {
        $orders = Order::with('descriptions')->whereIn('id', $ids)->get();

        foreach ($orders as $order) {
            $newOrder = $order->replicate();
            $newOrder->save();
        }
    }

    public function multiDelete($ids): void
    {
        Order::whereIn('id', $ids)->delete();
    }
}
