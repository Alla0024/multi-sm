<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MunicipalityDescription extends Model
{
    public $table = 'municipality_descriptions';

    public $fillable = [
        'municipality_id',
        'language_id',
        'name'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    public static array $rules = [
        'municipality_id' => 'required',
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
