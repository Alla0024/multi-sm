<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class PromoCodeGroupToPaymentMethod extends Model
{
    use HasCompositeKey;

    public $table = 'promo_code_group_to_payments';

    public $timestamps = false;

    protected $primaryKey = [
        'promo_code_group_id',
        'payment_id'
    ];

    public $fillable = [
        'promo_code_group_id',
        'payment_id'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'payment_id' => 'required',
        'promo_code_group_id' => 'required',
    ];

    public function promoCodeGroup(): BelongsTo
    {
        return $this->belongsTo(PromoCodeGroup::class, 'promo_code_group_id');
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment');
    }
}
