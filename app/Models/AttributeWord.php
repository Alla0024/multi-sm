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

    public function attributeWordDescription(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\AttributeWordDescription::class);
    }
    public function descriptions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\AttributeWordDescription::class, 'word_id');
    }
}
