<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class, NewsToNewsCategory::class);
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, NewsCategoryDescription::class);
    }
}
