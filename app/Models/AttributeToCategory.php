<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeToCategory extends Model
{
    public $table = 'attribute_to_category';

    public $fillable = [
        'attribute_id',
        'sort_order'
    ];

    protected $casts = [
        
    ];

    public static array $rules = [
        'attribute_id' => 'required',
        'sort_order' => 'required'
    ];

    public function attribute(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Attribute::class, 'attribute_id');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }
}
