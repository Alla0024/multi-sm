<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptionDescription extends Model
{
    public $timestamps = false;

    public function productOption()
    {
        return $this->belongsTo(ProductOption::class, 'option_id', 'option_id');
    }

    public function language()
    {
        return $this->belongsTo('App\Models\Language');
    }
}
