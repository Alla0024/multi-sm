<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filling extends Model
{
    public $table = 'filling';

    public $fillable = [
        'sort_order',
        'image'
    ];

    protected $casts = [
        'image' => 'string'
    ];

    public static array $rules = [
        'sort_order' => 'required',
        'image' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function fillingDescription(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\FillingDescription::class);
    }

    public function descriptions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\FillingDescription::class, 'filling_id');
    }
}
