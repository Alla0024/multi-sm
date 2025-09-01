<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeWord extends Model
{
    public $table = 'attribute_words';

    public $fillable = [
        'sort_order',
        'key'
    ];

    protected $casts = [
        'key' => 'string'
    ];

    public static array $rules = [
        'sort_order' => 'required',
        'key' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function productAttributes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\ProductAttribute::class, 'product_attribute_words');
    }

    public function attributeWordDescription(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\AttributeWordDescription::class);
    }
}
