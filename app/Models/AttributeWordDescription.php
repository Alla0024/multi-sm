<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeWordDescription extends Model
{
    public $table = 'attribute_word_descriptions';

    public $fillable = [
        'lang_id',
        'word',
        'description'
    ];

    protected $casts = [
        'word' => 'string',
        'description' => 'string'
    ];

    public static array $rules = [
        'lang_id' => 'required',
        'word' => 'required|string|max:255',
        'description' => 'required|string'
    ];

    public function word(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AttributeWord::class, 'word_id');
    }
}
