<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsToProduct extends Model
{
    public $table = 'new_to_products';

    public $fillable = [
        'news_id',
        'product_id',
        'sort_order'
    ];

    protected $casts = [

    ];

    public static array $rules = [
        'news_id' => 'required',
        'product_id' => 'required',
        'sort_order' => 'required'
    ];

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class, 'news_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
