<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class NewsDescription extends Model
{
    use HasCompositeKey;
    public $table = 'news_descriptions';
    public $timestamps = false;
    protected $primaryKey = ['news_id', 'language_id'];

    public $fillable = [
        'news_id',
        'language_id',
        'title',
        'description',
        'meta_title',
        'meta_h1',
        'meta_description',
        'meta_keyword',
        'products_title'
    ];

    public $searchable = [
        'news_id',
        'language_id',
        'title',
        'description',
        'meta_title',
        'meta_h1',
        'meta_description',
        'meta_keyword',
        'products_title'
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'meta_title' => 'string',
        'meta_h1' => 'string',
        'meta_description' => 'string',
        'meta_keyword' => 'string',
        'products_title' => 'string'
    ];

    public static array $rules = [
        'news_id' => 'required',
        'language_id' => 'required',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'meta_title' => 'nullable|string|max:255',
        'meta_h1' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:255',
        'meta_keyword' => 'nullable|string|max:255',
        'products_title' => 'nullable|string|max:255'
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class, 'news_id');
    }
}
