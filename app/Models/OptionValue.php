<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    public $table = 'option_values';

    public $fillable = [
        'parent_id',
        'type',
        'image',
        'level',
        'sort_order',
        'status',
        'default'
    ];

    protected $casts = [
        'type' => 'string',
        'image' => 'string',
        'status' => 'boolean'
    ];

    public static array $rules = [
        'parent_id' => 'nullable',
        'type' => 'required|string|max:255',
        'image' => 'required|string|max:255',
        'level' => 'required',
        'sort_order' => 'required',
        'status' => 'required|boolean',
        'default' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function productOptionValueToOptionValueGroups(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\ProductOptionValueToOptionValueGroup::class, 'option_value_id');
    }

    public function orderOptionProducts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\OrderOptionProduct::class, 'option_value_id');
    }

    public function optionValueDescription(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\OptionValueDescription::class);
    }
}
