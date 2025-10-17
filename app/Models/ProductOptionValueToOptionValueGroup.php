<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValueToOptionValueGroup extends Model
{
    public $timestamps = false;

    public function optionValue()
    {
        return $this->belongsTo(OptionValue::class)->with('description');
    }
}
