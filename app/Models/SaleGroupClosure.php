<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleGroupClosure extends Model
{
    protected $table = 'sale_group_closure';
    public $timestamps = false;

    protected $fillable = [
        'ancestor_id',
        'descendant_id',
        'depth',
    ];
}
