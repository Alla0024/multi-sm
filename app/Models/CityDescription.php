<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityDescription extends Model
{
    public $table = 'city_descriptions';

    public $fillable = [
        'city_id',
        'language_id',
        'name'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    public static array $rules = [
        'city_id' => 'required',
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
