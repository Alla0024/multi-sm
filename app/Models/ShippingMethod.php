<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    public $table = 'shipping_methods';

    public $fillable = [
        'minimum',
        'maximum',
        'depend',
        'value',
        'type',
        'status',
        'sort_order',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'depend' => 'string',
        'type' => 'string',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public static array $rules = [
        'minimum' => 'required',
        'maximum' => 'nullable',
        'depend' => 'nullable|string|max:255',
        'value' => 'required',
        'type' => 'nullable|string|max:15',
        'status' => 'required',
        'sort_order' => 'required',
        'start_date' => 'nullable',
        'end_date' => 'nullable'
    ];

    public function description()
    {
        return $this->hasOne(ShippingMethodDescription::class, 'shipping_method_id')
            ->where('language_id', config('settings.locale.default_language_id'));

    }

    public function descriptions()
    {
        return $this->hasMany(ShippingMethodDescription::class, 'shipping_method_id');
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, ShippingMethodToStore::class);
    }
    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Order::class, 'shipping_method_id');
    }

    public function promoCodeGroups(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\PromoCodeGroup::class, 'promo_code_group_to_shippings');
    }

    public function shippingMethodDescription(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\ShippingMethodDescription::class);
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Category::class, 'shipping_method_to_categories');
    }

    public function category1s(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Category::class, 'shipping_method_to_exception_categories');
    }

    public function locationGroups(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\LocationGroup::class, 'shipping_method_to_location_groups');
    }

    public function optionValueGroups(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\OptionValueGroup::class, 'shipping_method_to_option_value_groups');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Product::class, 'shipping_method_to_products');
    }

    public function segments(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Segment::class, 'shipping_method_to_segments');
    }

    public static function getShippingMethods()
    {
        return self::with('description')
            ->where('status', 1)
            ->get();
    }
}
