<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankDescription extends Model
{
    public $table = 'bank_descriptions';

    public $fillable = [
        'bank_id',
        'language_id',
        'name',
        'note'
    ];

    protected $casts = [
        'name' => 'string',
        'note' => 'string'
    ];

    public static array $rules = [
        'bank_id' => 'required',
        'language_id' => 'required',
        'name' => 'nullable|string|max:255',
        'note' => 'nullable|string|max:255'
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
