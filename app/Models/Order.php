<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = 'orders';

    public $fillable = [
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

    protected $casts = [
        'surname' => 'string',
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'address' => 'string',
        'comment' => 'string',
        'ref_settlement' => 'string',
        'payment_method_comment' => 'string',
        'shipping_method_comment' => 'string',
        'serialized_data' => 'string',
        'ip' => 'string',
        'user_agent' => 'string'
    ];

    public static array $rules = [
        'surname' => 'nullable|string|max:255',
        'name' => 'nullable|string|max:255',
        'email' => 'nullable|string|max:255',
        'phone' => 'required|string|max:255',
        'address' => 'nullable|string|max:255',
        'comment' => 'nullable|string|max:65535',
        'location_group_id' => 'required',
        'location_id' => 'required',
        'ref_settlement' => 'nullable|string|max:255',
        'payment_method_id' => 'required',
        'payment_method_comment' => 'nullable|string|max:65535',
        'shipping_method_id' => 'required',
        'shipping_method_comment' => 'nullable|string|max:255',
        'serialized_data' => 'nullable|string|max:65535',
        'client_id' => 'nullable',
        'total' => 'required',
        'promo_sum' => 'nullable',
        'order_status' => 'nullable',
        'status_from_1c' => 'required',
        'order_user_id' => 'nullable',
        'lead_id' => 'nullable',
        'ip' => 'required|string|max:255',
        'user_agent' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Client::class, 'client_id');
    }

    public function locationGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\LocationGroup::class, 'location_group_id');
    }

    public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_id');
    }

    public function paymentMethod(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\PaymentMethod::class, 'payment_method_id');
    }

    public function shippingMethod(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\ShippingMethod::class, 'shipping_method_id');
    }

    public function callTrackings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\CallTracking::class, 'order_id');
    }

    public function clientBonusPreviousHistories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\ClientBonusPreviousHistory::class, 'order_id');
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class, 'history_orders');
    }

    public function orderOptionProducts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\OrderOptionProduct::class, 'order_id');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Product::class, 'order_products');
    }

    public function orderTotals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\OrderTotal::class, 'order_id');
    }
}
