<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionDescription extends Model
{
    public $table = 'option_descriptions';

    public $fillable = [
        'language_id',
        'name',
        'comment'
    ];

    protected $casts = [
        'name' => 'string',
        'comment' => 'string'
    ];

    public static array $rules = [
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'comment' => 'nullable|string|max:255'
    ];

    public function option(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Option::class, 'option_id');
    }
}
