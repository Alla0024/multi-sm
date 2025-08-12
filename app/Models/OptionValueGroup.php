<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OptionValueGroup extends Model
{
    public $table = 'option_value_groups';

    public $fillable = [
        'option_id',
        'css_code',
        'image',
        'path',
        'sort_order'
    ];

    protected $casts = [
        'css_code' => 'string',
        'image' => 'string',
        'path' => 'string'
    ];

    public static array $rules = [
        'option_id' => 'required',
        'css_code' => 'required|string|max:55',
        'image' => 'required|string|max:255',
        'path' => 'required|string|max:255',
        'sort_order' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function productOptionValueToOptionValueGroups(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\ProductOptionValueToOptionValueGroup::class, 'option_value_group_id');
    }

    public function productOptionValueGroups(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\ProductOptionValueGroup::class, 'option_value_group_id');
    }

    public function orderOptionProducts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\OrderOptionProduct::class, 'option_value_group_id');
    }

    public function optionValueGroupDescription(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\OptionValueGroupDescription::class);
    }

    public function shippingMethods(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\ShippingMethod::class, 'shipping_method_to_option_value_groups');
    }

    public function optionValues(): HasMany {
        return $this->hasMany(OptionValue::class, 'parent_id');
    }

    public function descriptions(): HasMany {
        return $this->hasMany(OptionValueGroupDescription::class, 'option_value_group_id');
    }
}
