<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class PromoCodeGroupToShippingMethod extends Model
{
    use HasCompositeKey;

    public $table = 'promo_code_group_to_shippings';

    public $timestamps = false;

    protected $primaryKey = [
        'promo_code_group_id',
        'shipping_id'
    ];

    public $fillable = [
        'promo_code_group_id',
        'shipping_id'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'shipping_id' => 'required',
        'promo_code_group_id' => 'required',
    ];

    public function promoCodeGroup(): BelongsTo
    {
        return $this->belongsTo(PromoCodeGroup::class, 'promo_code_group_id');
    }

    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class, 'shipping');
    }
}
