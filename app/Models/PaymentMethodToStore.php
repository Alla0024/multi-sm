<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class PaymentMethodToStore extends Model
{
    use HasCompositeKey;

    public $table = 'payment_method_to_stores';

    public $timestamps = false;

    protected $primaryKey = [
        'payment_method_id',
        'store_id'
    ];

    public $fillable = [
        'payment_method_id',
        'store_id'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'store_id' => 'required',
        'payment_method_id' => 'required',
    ];

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
