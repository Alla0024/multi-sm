<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeIconDescription extends Model
{
    public $table = 'attribute_icon_descriptions';

    public $fillable = [
        'language_id',
        'title',
        'description'
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string'
    ];

    public static array $rules = [
        'language_id' => 'required',
        'title' => 'required|string|max:255',
        'description' => 'required|string'
    ];

    public function attributeIcon(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AttributeIcon::class, 'attribute_icon_id');
    }
}
