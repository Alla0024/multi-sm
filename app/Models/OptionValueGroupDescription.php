<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;

class OptionValueGroupDescription extends Model
{
    use HasCompositeKey;

    public $table = 'option_value_group_descriptions';
    public $timestamps = false;
    protected $primaryKey = ['option_value_group_id', 'language_id'];

    public $fillable = [
        'option_value_group_id',
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
