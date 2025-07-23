<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class New extends Model
{
    public $table = 'news';

    public $fillable = [
        'category_id',
        'author_id',
        'thumbnail',
        'sort_order',
        'status',
        'shared_on_facebook',
        'shared_on_twitter',
        'reviews_count',
        'reviews_rating'
    ];

    protected $casts = [
        'thumbnail' => 'string',
        'reviews_rating' => 'float'
    ];

    public static array $rules = [
        'category_id' => 'nullable',
        'author_id' => 'nullable',
        'thumbnail' => 'required|string|max:255',
        'sort_order' => 'required',
        'status' => 'required',
        'shared_on_facebook' => 'nullable',
        'shared_on_twitter' => 'nullable',
        'reviews_count' => 'required',
        'reviews_rating' => 'required|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\ArticleAuthor::class, 'author_id');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    public function newsCategories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\NewsCategory::class, 'news_to_news_categories');
    }

    public function languages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Language::class, 'news_descriptions');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Product::class, 'new_to_products');
    }

    public function category1s(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Category::class, 'new_to_categories');
    }
}
