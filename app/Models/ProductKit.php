<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductKit extends Model
{
    public $timestamps = false;

    public function description()
    {
        return $this->hasOne(ProductDescription::class, 'product_id', 'kit_id')->where('language_id', config('settings.locale.default_language_id'));
    }
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'kit_id');
    }

    public function kitProduct()
    {
        return $this->belongsTo(Product::class, 'kit_product_id');
    }
}
