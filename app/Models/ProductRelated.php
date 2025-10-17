<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRelated extends Model
{
    protected $table = 'product_relateds';

    public $timestamps = false;

    public function description(){
        return $this->hasOne(ProductDescription::class)->where('language_id', config('settings.locale.default_language_id'));
    }
}
