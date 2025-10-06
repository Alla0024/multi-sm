<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopSales extends Model
{
    public $timestamps = false;

    protected $table = 'top_sales';

    public function description()
    {
        return $this->hasOne('App\Models\ProductDescription', 'product_id', 'product_id')
            ->where("language_id", config('settings.locale.default_language_id'));
    }
}
