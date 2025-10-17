<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanionProduct extends Model
{
    public $timestamps = false;

    public function description()
    {
        return $this->hasOne(ProductDescription::class, 'product_id', 'product_id')
            ->where('language_id', config('settings.locale.default_language_id'));
    }
}
