<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsCategoryDescription extends Model
{
    public $table = 'news_category_descriptions';

    public $fillable = [
        'news_category_id',
        'language_id',
        'name'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    public static array $rules = [
        'news_category_id' => 'required',
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function newsCategory(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }
}
