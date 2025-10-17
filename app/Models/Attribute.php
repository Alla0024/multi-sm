<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function attributeGroup(): BelongsTo
    {
        return $this->belongsTo(AttributeGroup::class, 'attribute_group_id')->with('description');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'attribute_to_category');
    }

    public function attributeIconToAttributes(): HasMany
    {
        return $this->hasMany(AttributeIconToAttribute::class, 'attribute_id');
    }

    public function productAttributeIcons()
    {
        return $this->hasManyThrough(ProductAttributeIcon::class, AttributeIconToAttribute::class, 'attribute_id', 'id', 'id', 'attribute_icon_id')->with('description');
    }

    public function productAttributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class, 'attribute_id');
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(AttributeDescription::class, 'attribute_id');
    }

    public function description(): HasOne
    {
        return $this->hasOne(AttributeDescription::class, 'attribute_id')->where('language_id', config('settings.locale.default_language_id'));
    }

    public function attribute_group(): BelongsTo
    {
        return $this->belongsTo('App\Models\AttributeGroup')->with('description');

    }
}
