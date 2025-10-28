<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public $table = 'sales';

    public $fillable = [
        'sort_order',
        'status',
        'hidden',
        'date_start',
        'date_end',
        'time_start',
        'time_end',
        'loop',
        'show_in_product',
        'show_in_sale',
        'show_more_sale_url',
        'default_sale_shop',
        'compare_options',
        'has_one_activator',
        'accrue',
        'icon'
    ];

    protected $casts = [
        'status' => 'boolean',
        'date_start' => 'datetime',
        'date_end' => 'datetime',
        'loop' => 'boolean',
        'show_in_sale' => 'boolean',
        'show_more_sale_url' => 'string',
        'default_sale_shop' => 'boolean',
        'compare_options' => 'boolean',
        'accrue' => 'boolean',
        'icon' => 'string'
    ];

    public static array $rules = [
        'sort_order' => 'required',
        'status' => 'required|boolean',
        'hidden' => 'required',
        'date_start' => 'required',
        'date_end' => 'required',
        'time_start' => 'required',
        'time_end' => 'required',
        'loop' => 'required|boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'show_in_product' => 'nullable',
        'show_in_sale' => 'required|boolean',
        'show_more_sale_url' => 'nullable|string|max:255',
        'default_sale_shop' => 'required|boolean',
        'compare_options' => 'required|boolean',
        'has_one_activator' => 'required',
        'accrue' => 'required|boolean',
        'icon' => 'nullable|string|max:255'
    ];
    public function description()
    {
        return $this->hasOne(SaleDescription::class, 'sale_id')
            ->where('language_id', config('settings.locale.default_language_id'));

    }

    public function descriptions()
    {
        return $this->hasMany(SaleDescription::class, 'sale_id');
    }
    public function seoPath()
    {
        return $this->hasOne(FirstPathQuery::class, 'type_id')->where('type', 'sale');
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, SaleToStore::class);
    }
    public function saleGroups(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\SaleGroup::class, 'sale_group_to_sales');
    }

    public function saleGroup1s(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\SaleGroup::class, 'sale_group_to_sales_copy');
    }

    public function paymentMethods(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\PaymentMethod::class, 'sale_to_payments');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Product::class, 'sale_to_products');
    }

    public function segments(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Segment::class, 'sale_to_segments');
    }
}
