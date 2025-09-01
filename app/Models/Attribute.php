<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    public $table = 'attributes';

    public $fillable = [
        'attribute_group_id',
        'sort_order'
    ];

    protected $casts = [
        
    ];

    public static array $rules = [
        'attribute_group_id' => 'required',
        'sort_order' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function attributeGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AttributeGroup::class, 'attribute_group_id');
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Category::class, 'attribute_to_category');
    }

    public function attributeIconToAttributes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\AttributeIconToAttribute::class, 'attribute_id');
    }

    public function productAttributeIcons(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\ProductAttributeIcon::class, 'attribute_id');
    }

    public function productAttributes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\ProductAttribute::class, 'attribute_id');
    }

    public function attributeDescription(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\AttributeDescription::class);
    }
}
