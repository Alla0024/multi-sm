<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFilling extends Model
{
    public $timestamps = false;

    protected $table = 'product_filling';

    public $incrementing = false;
    public function description()
    {
        return $this->hasOne(ProductDescription::class, 'product_id', 'product_id')->where('language_id', config('settings.locale.default_language_id'));
    }
}
