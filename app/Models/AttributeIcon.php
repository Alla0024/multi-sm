<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'pattern' => 'nullable|string',
        'value' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function attributeIconToAttributes(): HasMany
    {
        return $this->hasMany(AttributeIconToAttribute::class, 'attribute_icon_id');
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(AttributeIconDescription::class, 'attribute_icon_id');
    }

    public function productAttributeIcons(): HasMany
    {
        return $this->hasMany(ProductAttributeIcon::class, 'icon_id');
    }
}
