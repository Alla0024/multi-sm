<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValueGroup extends Model
{
    public $table = 'product_option_value_groups';

    public $fillable = [
        'option_id',
        'option_value_group_id',
        'c1',
        'hash',
        'sort_order'
    ];

    protected $casts = [
        'c1' => 'string',
        'hash' => 'string'
    ];

    public static array $rules = [
        'option_id' => 'required',
        'option_value_group_id' => 'required',
        'c1' => 'nullable|string|max:255',
        'hash' => 'nullable|string|max:255',
        'sort_order' => 'required'
    ];

    public function option(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Option::class, 'option_id');
    }

    public function optionValueGroup()
    {
        return $this->belongsTo(OptionValueGroup::class, 'option_value_group_id')->with('description');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }
}
