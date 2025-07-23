<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
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

    public function author()
    {
        return $this->belongsTo(ArticleAuthor::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function newsCategories()
    {
        return $this->belongsToMany(NewsCategory::class, 'news_to_news_categories');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'news_descriptions');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'new_to_products');
    }

    public function category1s()
    {
        return $this->belongsToMany(Category::class, 'new_to_categories');
    }
}
