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
        'date_of_birth',
        'facebook',
        'instagram'
    ];

    protected $casts = [
        'avatar' => 'string',
        'date_of_birth' => 'date',
        'facebook' => 'string',
        'instagram' => 'string'
    ];

    public static array $rules = [
        'avatar' => 'nullable|string|max:255',
        'date_of_birth' => 'nullable',
        'facebook' => 'required|url',
        'instagram' => 'required|url'
    ];

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'article_author_descriptions');
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(ArticleAuthorDescription::class, 'author_id');
    }

    public function news(): HasMany
    {
        return $this->hasMany(\App\Models\News::class, 'author_id');
    }
}
