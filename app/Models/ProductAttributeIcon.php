<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeIcon extends Model
{
    public $timestamps = false;

    protected $table = 'product_attribute_icons';
    public $incrementing = false;

    protected $fillable = [
        'product_id',
        'attribute_id',
        'icon_id',
    ];
}
