<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    public $table = 'news_categories';

    public $fillable = [
        'status',
        'seo_url',
        'color',
        'sort_order'
    ];

    protected $casts = [
        'status' => 'boolean',
        'seo_url' => 'string',
        'color' => 'string'
    ];

    public static array $rules = [
        'status' => 'required|boolean',
        'seo_url' => 'nullable|string|max:255',
        'color' => 'nullable|string|max:255',
        'sort_order' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function news(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\News::class, 'news_to_news_categories');
    }

    public function languages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Language::class, 'news_category_descriptions');
    }
}
