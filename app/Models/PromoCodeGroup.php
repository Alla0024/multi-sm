<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCodeGroup extends Model
{
    public $table = 'promo_code_groups';

    public $fillable = [
        'status',
        'sort_order',
        'value',
        'change_number',
        'apply_immediately',
        'must_be_all_products',
        'type_number',
        'min_total_price',
        'min_product_price',
        'max_total_price',
        'max_product_price',
        'apply_for_products',
        'date_start',
        'date_end'
    ];

    protected $casts = [
        'status' => 'string',
        'value' => 'float',
        'apply_immediately' => 'boolean',
        'must_be_all_products' => 'boolean',
        'type_number' => 'string',
        'apply_for_products' => 'boolean',
        'date_start' => 'datetime',
        'date_end' => 'datetime'
    ];

    public static array $rules = [
        'status' => 'required|string|max:255',
        'sort_order' => 'nullable',
        'value' => 'nullable|numeric',
        'change_number' => 'nullable',
        'apply_immediately' => 'required|boolean',
        'must_be_all_products' => 'required|boolean',
        'type_number' => 'nullable|string|max:255',
        'min_total_price' => 'nullable',
        'min_product_price' => 'nullable',
        'max_total_price' => 'nullable',
        'max_product_price' => 'nullable',
        'apply_for_products' => 'required|boolean',
        'date_start' => 'nullable',
        'date_end' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
    public function description()
    {
        return $this->hasOne(PromoCodeGroupDescription::class, 'promo_code_group_id')
            ->where('language_id', config('settings.locale.default_language_id'));

    }

    public function descriptions()
    {
        return $this->hasMany(PromoCodeGroupDescription::class, 'promo_code_group_id');
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, PromoCodeGroupToStore::class);
    }

    public function languages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Language::class, 'promo_code_group_descriptions');
    }

    public function segments()
    {
        return $this->belongsToMany(Segment::class, PromoCodeGroupToSegment::class);
    }

    public function activatorSegments()
    {
        return $this->belongsToMany(Segment::class, PromoCodeGroupToActivatorSegment::class, 'segment_id', 'promo_code_group_id');
    }

    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class, PromoCodeGroupToPaymentMethod::class, 'payment_id', 'promo_code_group_id');
    }

    public function shippingMethods()
    {
        return $this->belongsToMany(\App\Models\ShippingMethod::class, PromoCodeGroupToShippingMethod::class, 'shipping_id', 'promo_code_group_id');
    }

    public function promoCodes()
    {
        return $this->hasMany(PromoCode::class, 'promo_code_group_id');
    }

    public function saleGroups(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\SaleGroup::class, 'sale_group_to_promo_code_groups');
    }

    public static function getPromoCodeGroups()
    {
        return self::with('description')
            ->where('status', 1)
            ->get();
    }
}
