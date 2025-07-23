<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsToNewsCategory extends Model
{
    public $table = 'news_to_news_categories';

    public $fillable = [
        'news_id',
        'news_category_id'
    ];

    protected $casts = [

    ];

    public static array $rules = [
        'news_id' => 'required',
        'news_category_id' => 'required'
    ];

//    public function newsCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
//    {
//        return $this->belongsTo(\App\Models\NewsCategory::class, 'news_category_id');
//    }

    public function news(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\News::class, 'news_id');
    }
}
