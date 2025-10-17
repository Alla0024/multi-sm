<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFilling extends Model
{
    public $timestamps = false;

    protected $table = 'product_filling';

    public function description()
    {
        return $this->hasOne(ProductDescription::class)->where('language_id', config('settings.locale.default_language_id'));
    }
}
