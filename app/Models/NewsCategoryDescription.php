<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategoryDescription extends Model
{
    public $table = 'news_category_descriptions';

    public $fillable = [
        'news_category_id',
        'language_id',
        'name'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    public static array $rules = [
        'news_category_id' => 'required',
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function language(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Language::class, 'language_id');
    }

    public function newsCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\NewsCategory::class, 'news_category_id');
    }
}
