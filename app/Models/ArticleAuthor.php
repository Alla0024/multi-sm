<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleAuthor extends Model
{
    public $table = 'article_authors';

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
        'facebook' => 'required|string',
        'instagram' => 'required|string'
    ];

    public function languages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Language::class, 'article_author_descriptions');
    }

    public function news(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\News::class, 'author_id');
    }
}
