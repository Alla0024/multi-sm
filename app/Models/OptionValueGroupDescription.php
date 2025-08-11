<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionValueGroupDescription extends Model
{
    public $table = 'option_value_group_descriptions';

    public $fillable = [
        'language_id',
        'name',
        'meta_title'
    ];

    protected $casts = [
        'name' => 'string',
        'meta_title' => 'string'
    ];

    public static array $rules = [
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'meta_title' => 'required|string|max:255'
    ];

    public function optionValueGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\OptionValueGroup::class, 'option_value_group_id');
    }
}
