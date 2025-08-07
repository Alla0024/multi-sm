<?php

namespace App\Models;

use App\Traits\SearchableBySimilarity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class ArticleAuthorDescription extends Model
{
    use HasCompositeKey, SearchableBySimilarity;

    public $table = 'article_author_descriptions';
    public $timestamps = false;
    protected $primaryKey = ['author_id', 'language_id'];

    public $fillable = [
        'author_id',
        'language_id',
        'name',
        'description'
    ];

    protected $casts = [
        'author_id' => 'string',
        'name' => 'string',
        'description' => 'string'
    ];

    public static array $rules = [
        'author_id' => 'required',
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'description' => 'required|string'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(ArticleAuthor::class, 'author_id');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
