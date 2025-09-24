<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilterGroupDescription extends Model
{
    public $table = 'filter_group_descriptions';

    public $fillable = [
        'language_id',
        'name',
        'meta_title',
        'comment'
    ];

    protected $casts = [
        'name' => 'string',
        'meta_title' => 'string',
        'comment' => 'string'
    ];

    public static array $rules = [
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'meta_title' => 'nullable|string|max:255',
        'comment' => 'nullable|string|max:255'
    ];

    public function filterGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\FilterGroup::class, 'filter_group_id');
    }
    public function language(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Language::class, 'language_id');
    }
}
