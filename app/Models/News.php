<?php

namespace App\Models;

use App\Traits\SearchableBySimilarity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class News extends Model
{
    use SearchableBySimilarity;

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
        return $this->belongsToMany(NewsCategory::class, NewsToNewsCategory::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, NewsDescription::class);
    }

    public function descriptions()
    {
        return $this->hasMany(NewsDescription::class, 'news_id');
    }

    public function seoPath(): HasOne
    {
        return $this->hasOne(FirstPathQuery::class, 'type_id')->where('type', 'news');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, NewsToProduct::class);
    }

    public function category1c()
    {
        return $this->belongsToMany(Category::class, NewsToCategory::class);
    }
}
