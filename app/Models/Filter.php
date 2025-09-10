<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    public $table = 'filters';

    public $fillable = [
        'filter_group_id',
        'path',
        'sort_order',
        'default_viewed',
        'parent',
        'parent_id'
    ];

    protected $casts = [
        'path' => 'string',
        'parent' => 'boolean'
    ];

    public static array $rules = [
        'filter_group_id' => 'required',
        'path' => 'required|string|max:255',
        'sort_order' => 'required',
        'default_viewed' => 'nullable',
        'parent' => 'required|boolean',
        'parent_id' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function filterGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\FilterGroup::class, 'filter_group_id');
    }

    public function filterDescription(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\FilterDescription::class);
    }

    public function filterToCategory(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\FilterToCategory::class);
    }

    public function optionValueGroups(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\OptionValueGroup::class, 'filter_to_option_value_groups');
    }
}
