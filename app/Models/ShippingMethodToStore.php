<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class ShippingMethodToStore extends Model
{
    use HasCompositeKey;

    public $table = 'shipping_method_to_stores';

    public $timestamps = false;

    protected $primaryKey = [
        'shipping_method_id',
        'store_id'
    ];

    public $fillable = [
        'shipping_method_id',
        'store_id'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'store_id' => 'required',
        'shipping_method_id' => 'required',
    ];

    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class, 'shipping_method_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
