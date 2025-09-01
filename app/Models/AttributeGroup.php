<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{
    public $table = 'attribute_groups';

    public $fillable = [
        'sort_order'
    ];

    protected $casts = [
        
    ];

    public static array $rules = [
        'sort_order' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function attributeGroupDescription(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\AttributeGroupDescription::class);
    }

    public function attributes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Attribute::class, 'attribute_group_id');
    }
}
