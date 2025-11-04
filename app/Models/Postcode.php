<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postcode extends Model
{
    public $table = 'postcodes';

    public $fillable = [
        'status',
        'postcode',
        'city_id',
        'province_id',
        'municipality_id'
    ];

    protected $casts = [
        'status' => 'boolean',
        'postcode' => 'string'
    ];

    public static array $rules = [
        'status' => 'nullable|boolean',
        'postcode' => 'required|string|max:255',
        'city_id' => 'required',
        'province_id' => 'required',
        'municipality_id' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function city()
    {
        return $this->hasOne(City::class, 'city_id')->with('description');
    }

    public function province()
    {
        return $this->hasOne(Province::class, 'province_id')->with('description');
    }

    public function municipality()
    {
        return $this->hasOne(Municipality::class, 'municipality_id')->with('description');
    }
}
