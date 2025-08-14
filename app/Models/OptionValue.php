<?php

namespace App\Models;

use App\Traits\SearchableBySimilarity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OptionValue extends Model
{
    use SearchableBySimilarity;

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

    public function productOptionValueToOptionValueGroups(): HasMany
    {
        return $this->hasMany(ProductOptionValueToOptionValueGroup::class, 'option_value_id');
    }

    public function orderOptionProducts(): HasMany
    {
        return $this->hasMany(OrderOptionProduct::class, 'option_value_id');
    }

    public function optionValueDescription(): HasOne
    {
        return $this->hasOne(OptionValueDescription::class);
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(OptionValueDescription::class, 'option_value_id');
    }
}
