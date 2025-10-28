<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusProgramDescription extends Model
{
    public $table = 'bonus_program_descriptions';

    public $fillable = [
        'bonus_program_id',
        'language_id',
        'name',
        'header',
        'mini_description',
        'description',
        'text'
    ];

    protected $casts = [
        'name' => 'string',
        'header' => 'string',
        'mini_description' => 'string',
        'description' => 'string',
        'text' => 'string'
    ];

    public static array $rules = [
        'bonus_program_id' => 'required',
        'language_id' => 'required',
        'name' => 'nullable|string|max:255',
        'header' => 'nullable|string|max:255',
        'mini_description' => 'nullable|string|max:65535',
        'description' => 'nullable|string|max:65535',
        'text' => 'nullable|string|max:65535',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function bonusProgram()
    {
        return $this->belongsTo(BonusProgram::class, 'bonus_program_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
