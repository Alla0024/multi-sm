<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $table = 'cities';

    public $fillable = [
        'status'
    ];

    protected $casts = [

    ];

    public static array $rules = [
        'status' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function description()
    {
        return $this->hasOne(CityDescription::class, 'city_id')
            ->where('language_id', config('settings.locale.default_language_id'));

    }

    public function descriptions()
    {
        return $this->hasMany(CityDescription::class, 'city_id');
    }

}
