<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeIcon extends Model
{
    public $table = 'attribute_icons';

    public $fillable = [
        'image',
        'pattern',
        'value'
    ];

    protected $casts = [
        'image' => 'string',
        'pattern' => 'string'
    ];

    public static array $rules = [
        'image' => 'required|string|max:255',
        'pattern' => 'required|string',
        'value' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function attributeIconToAttributes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\AttributeIconToAttribute::class, 'attribute_icon_id');
    }

    public function attributeIconDescription(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\AttributeIconDescription::class);
    }

    public function productAttributeIcons(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\ProductAttributeIcon::class, 'icon_id');
    }
}
