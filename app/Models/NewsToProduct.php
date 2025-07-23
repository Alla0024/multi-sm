<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsToProduct extends Model
{
    public $table = 'new_to_products';

    public $fillable = [
        'product_id',
        'sort_order'
    ];

    protected $casts = [

    ];

    public static array $rules = [
        'product_id' => 'required',
        'sort_order' => 'required'
    ];

    public function news(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\News::class, 'news_id');
    }

//    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
//    {
//        return $this->belongsTo(\App\Models\Product::class, 'product_id');
//    }
}
