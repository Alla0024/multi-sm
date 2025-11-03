<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankProgram extends Model
{
    public $table = 'bank_programs';

    public $fillable = [
        'mark',
        'bank_id',
        'logo',
        'sort_order',
        'min',
        'max',
        'step',
        'value',
        'month',
        'status'
    ];

    protected $casts = [
        'mark' => 'string',
        'logo' => 'string'
    ];

    public static array $rules = [
        'mark' => 'nullable|string|max:255',
        'bank_id' => 'required',
        'logo' => 'nullable|string|max:255',
        'sort_order' => 'required',
        'min' => 'required',
        'max' => 'required',
        'step' => 'required',
        'value' => 'required',
        'month' => 'required',
        'status' => 'required'
    ];

    public function description()
    {
        return $this->hasOne(BankProgramDescription::class, 'bank_program_id')
            ->where('language_id', config('settings.locale.default_language_id'));

    }

    public function descriptions()
    {
        return $this->hasMany(BankProgramDescription::class, 'bank_program_id');
    }

    public function bank(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Bank::class, 'bank_id');
    }

    public function languages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Language::class, 'bank_program_descriptions');
    }

    public function bankProgramToProducts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\BankProgramToProduct::class, 'bank_program_id');
    }

    public function receipts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Receipt::class, 'bank_program_id');
    }
}
