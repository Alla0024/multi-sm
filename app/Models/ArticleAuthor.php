<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleAuthor extends Model
{
    public $table = 'article_authors';
    public $timestamps = false;

    public $fillable = [
        'avatar',
        'facebook',
        'instagram'
    ];

    protected $casts = [
        'avatar' => 'string',
        'facebook' => 'string',
        'instagram' => 'string'
    ];

    public static array $rules = [
        'avatar' => 'nullable|string|max:255',
        'facebook' => 'required|url',
        'instagram' => 'required|url'
    ];

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, ArticleAuthorDescription::class);
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(ArticleAuthorDescription::class, 'author_id');
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'author_id');
    }
}
