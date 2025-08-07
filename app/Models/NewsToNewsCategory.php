<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;

class NewsToNewsCategory extends Model
{
    use HasCompositeKey;

    public $table = 'news_to_news_categories';
    public $timestamps = false;
    protected $primaryKey = [
        'news_id',
        'news_category_id'
    ];

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

    public function newsCategory()
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }
}
