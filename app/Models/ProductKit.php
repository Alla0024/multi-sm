<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductKit extends Model
{
    public $timestamps = false;

    public function description()
    {
        return $this->hasOne(ProductDescription::class)->where('language_id', config('settings.locale.default_language_id'));
    }
}
