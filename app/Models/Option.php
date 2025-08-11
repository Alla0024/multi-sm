<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Option extends Model
{
    public $table = 'options';

    public $fillable = [
        'type',
        'sort_order',
        'path'
    ];

    protected $casts = [
        'type' => 'string',
        'path' => 'string'
    ];

    public static array $rules = [
        'type' => 'required|string|max:255',
        'sort_order' => 'required',
        'path' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function filterGroups(): HasMany
    {
        return $this->hasMany(FilterGroup::class, 'option_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_options');
    }

    public function productOptionValueToOptionValueGroups(): HasMany
    {
        return $this->hasMany(ProductOptionValueToOptionValueGroup::class, 'option_id');
    }

    public function productOptionValueGroups(): HasMany
    {
        return $this->hasMany(ProductOptionValueGroup::class, 'option_id');
    }

    public function productOptionDescriptions(): HasMany
    {
        return $this->hasMany(ProductOptionDescription::class, 'option_id');
    }

    public function orderOptionProducts(): HasMany
    {
        return $this->hasMany(OrderOptionProduct::class, 'option_id');
    }
    public function optionDescription(): HasOne
    {
        return $this->hasOne(OptionDescription::class);
    }
}
