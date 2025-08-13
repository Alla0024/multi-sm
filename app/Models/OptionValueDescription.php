<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;

class OptionValueDescription extends Model
{
    use HasCompositeKey;

    public $table = 'option_value_descriptions';
    public $timestamps = false;
    protected $primaryKey = [
        'option_value_id',
        'language_id',
    ];

    public $fillable = [
        'option_value_id',
        'language_id',
        'name',
        'type_material'
    ];

    protected $casts = [
        'name' => 'string',
        'type_material' => 'string'
    ];

    public static array $rules = [
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'type_material' => 'required|string'
    ];

    public function optionValue(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\OptionValue::class, 'option_value_id');
    }
}
