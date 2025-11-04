<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvinceDescription extends Model
{
    public $table = 'province_descriptions';

    public $fillable = [
        'province_id',
        'language_id',
        'name'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    public static array $rules = [
        'province_id' => 'required',
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
