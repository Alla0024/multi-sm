<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSimilar extends Model
{
    public $timestamps = false;

    public function description()
    {
        return $this->hasOne(ProductDescription::class, 'product_id', 'similar_id')
            ->where('language_id', config('settings.locale.default_language_id'));
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'similar_id');
    }
}
