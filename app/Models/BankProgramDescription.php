<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankProgramDescription extends Model
{
    public $table = 'bank_program_descriptions';

    public $fillable = [
        'bank_program_id',
        'language_id',
        'title',
        'note'
    ];

    protected $casts = [
        'title' => 'string',
        'note' => 'string'
    ];

    public static array $rules = [
        'bank_program_id' => 'required',
        'language_id' => 'required',
        'title' => 'nullable|string|max:255',
        'note' => 'nullable|string|max:255'
    ];

    public function bankProgram()
    {
        return $this->belongsTo(BankProgram::class, 'bank_program_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
