<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class SaleGroupToPromoCodeGroup extends Model
{
    use HasCompositeKey;

    public $table = 'sale_group_to_promo_code_groups';

    public $timestamps = false;

    protected $primaryKey = [
        'sale_group_id',
        'promo_code_group_id'
    ];

    public $fillable = [
        'sale_group_id',
        'promo_code_group_id'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'sale_group_id' => 'required',
        'promo_code_group_id' => 'required',
    ];

    public function saleGroup(): BelongsTo
    {
        return $this->belongsTo(SaleGroup::class, 'sale_group_id');
    }

    public function promoCodeGroup(): BelongsTo
    {
        return $this->belongsTo(PromoCodeGroup::class, 'promo_code_group_id');
    }
}
