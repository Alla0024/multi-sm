<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    public $table = 'banks';

    public $fillable = [
        'mark',
        'logo',
        'sort_order'
    ];

    protected $casts = [
        'mark' => 'string',
        'logo' => 'string'
    ];

    public static array $rules = [
        'mark' => 'nullable|string|max:255',
        'logo' => 'nullable|string|max:255',
        'sort_order' => 'required'
    ];

    public function description()
    {
        return $this->hasOne(BankDescription::class, 'bank_id')
            ->where('language_id', config('settings.locale.default_language_id'));

    }

    public function descriptions()
    {
        return $this->hasMany(BankDescription::class, 'bank_id');
    }

    public function languages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Language::class, 'bank_descriptions');
    }

    public function bankProgramToProducts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\BankProgramToProduct::class, 'bank_id');
    }

    public function bankPrograms(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\BankProgram::class, 'bank_id');
    }

    public function individualEntrepreneurs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\IndividualEntrepreneur::class, 'bank_id');
    }

    public function receipts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Receipt::class, 'bank_id');
    }
}
