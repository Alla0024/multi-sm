<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class SaleToPaymentMethod extends Model
{
    use HasCompositeKey;

    public $table = 'sale_to_payments';

    public $timestamps = false;

    protected $primaryKey = [
        'sale_id',
        'payment_id'
    ];

    public $fillable = [
        'sale_id',
        'payment_id'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'payment_id' => 'required',
        'sale_id' => 'required',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment');
    }
}
