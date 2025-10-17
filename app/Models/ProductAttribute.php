<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    public $timestamps = false;

    public function description()
    {
        return $this->hasOne(AttributeDescription::class)->where('language_id', config('settings.locale.default_language_id'));
    }

    public function descriptions()
    {
        return $this->hasMany(ProductAttributeDescription::class);
    }

    public function attribute()
    {
        return $this->hasOne(Attribute::class, 'id', 'attribute_id')
            ->with('description', 'attributeGroup', 'icons');
    }

    public function words()
    {
        return $this->belongsToMany(AttributeWord::class, ProductAttributeWord::class, 'product_attribute_id', 'word_id')
            ->with('description');
    }
}
