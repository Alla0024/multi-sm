<?php

namespace App\Models;

use App\Traits\SearchableBySimilarity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'reviews_count' => 'required',
        'reviews_rating' => 'required|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(ArticleAuthor::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function newsCategories(): BelongsToMany
    {
        return $this->belongsToMany(NewsCategory::class, NewsToNewsCategory::class);
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, NewsDescription::class);
    }

    public function description(): HasOne
    {
        return $this->hasOne(NewsDescription::class, 'news_id')->where('language_id', config('settings.locale.default_language_id'));
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(NewsDescription::class, 'news_id');
    }

    public function seoPath(): HasOne
    {
        return $this->hasOne(FirstPathQuery::class, 'type_id')->where('type', 'news');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, NewsToProduct::class);
    }

    public function category1c(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, NewsToCategory::class);
    }
}
