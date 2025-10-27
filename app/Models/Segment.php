<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Segment extends Model
{
    public $table = 'segments';

    public $fillable = [
        'status',
        'hash',
        'product_count',
        'value',
        'type_number',
        'choose_price',
        'calculation_from',
        'show_in_sale',
        'sort_order'
    ];

    protected $casts = [
        'status' => 'boolean',
        'hash' => 'string',
        'value' => 'float',
        'type_number' => 'string'
    ];

    public static array $rules = [
        'status' => 'required|boolean',
        'hash' => 'nullable|string|max:255',
        'product_count' => 'required',
        'value' => 'required|numeric',
        'type_number' => 'required|string|max:255',
        'choose_price' => 'nullable',
        'calculation_from' => 'nullable',
        'show_in_sale' => 'nullable',
        'sort_order' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function description()
    {
        return $this->hasOne(SegmentDescription::class, 'segment_id')
            ->where('language_id', config('settings.locale.default_language_id'));

    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(SegmentDescription::class, 'segment_id');
    }
    public function bonusPrograms(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\BonusProgram::class, 'bonus_program_to_segments');
    }

    public function promoCodeGroups(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\PromoCodeGroup::class, 'promo_code_group_to_activator_segments');
    }

    public function promoCodeGroup1s(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\PromoCodeGroup::class, 'promo_code_group_to_segments');
    }

    public function sales(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Sale::class, 'sale_to_segments');
    }

    public function languages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Language::class, 'segment_descriptions');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Product::class, 'segment_to_products');
    }

    public function shippingMethods(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\ShippingMethod::class, 'shipping_method_to_segments');
    }

    public function updateSegmentProducts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\UpdateSegmentProduct::class, 'segment_id');
    }
}
