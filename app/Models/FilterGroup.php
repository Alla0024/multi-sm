<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilterGroup extends Model
{
    public $table = 'filter_groups';

    public $fillable = [
        'type',
        'option_id',
        'sort_order',
        'path'
    ];

    protected $casts = [
        'type' => 'string',
        'path' => 'string'
    ];

    public static array $rules = [
        'type' => 'required|string|max:255',
        'option_id' => 'nullable',
        'sort_order' => 'required',
        'path' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function option(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Option::class, 'option_id');
    }

    public function descriptions()
    {
        return $this->hasMany(FilterGroupDescription::class, 'filter_group_id');
    }

    public function filterGroupDescription(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\FilterGroupDescription::class);
    }

    public function filterToCategories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\FilterToCategory::class, 'filter_group_id');
    }

    public function filters(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Filter::class, 'filter_group_id');
    }
}
