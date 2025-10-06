<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilterToCategory extends Model
{
    public $timestamps = false;

    public $table = 'filter_to_category';

    protected $fillable = [
        'filter_id',
        'category_id'
    ];

    public static array $rules = [
        'filter_id' => 'required',
        'category_id' => 'required'
    ];

    public function filter()
    {
        return $this->belongsTo(\App\Models\Filter::class, 'filter_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id')->with('descriptions');
    }
}
