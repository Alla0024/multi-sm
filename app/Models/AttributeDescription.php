<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeDescription extends Model
{
    public $table = 'attribute_descriptions';

    public $fillable = [
        'language_id',
        'name',
        'explanation'
    ];

    protected $casts = [
        'name' => 'string',
        'explanation' => 'string'
    ];

    public static array $rules = [
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'explanation' => 'nullable|string|max:255'
    ];

    public function attribute(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Attribute::class, 'attribute_id');
    }
}
