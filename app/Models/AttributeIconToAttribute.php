<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeIconToAttribute extends Model
{
    public $table = 'attribute_icon_to_attributes';

    public $fillable = [
        'attribute_id',
        'attribute_icon_id'
    ];

    protected $casts = [

    ];

    public static array $rules = [
        'attribute_id' => 'required',
        'attribute_icon_id' => 'required'
    ];

    public function attributeIcon(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AttributeIcon::class, 'attribute_icon_id');
    }

    public function attribute(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Attribute::class, 'attribute_id');
    }
    public function icon(){
        return $this->belongsTo(AttributeIcon::class, 'attribute_icon_id', 'id')->with('description');
    }
}
