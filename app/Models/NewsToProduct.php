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

    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
