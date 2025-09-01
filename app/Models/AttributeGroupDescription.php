<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeGroupDescription extends Model
{
    public $table = 'attribute_group_descriptions';

    public $fillable = [
        'language_id',
        'name'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    public static array $rules = [
        'language_id' => 'required',
        'name' => 'required|string|max:255'
    ];

    public function attributeGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AttributeGroup::class, 'attribute_group_id');
    }
}
