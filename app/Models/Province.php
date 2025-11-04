<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $table = 'provinces';

    public $fillable = [
        'code'
    ];

    protected $casts = [
        'code' => 'string'
    ];

    public static array $rules = [
        'code' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function description()
    {
        return $this->hasOne(ProvinceDescription::class, 'province_id')
            ->where('language_id', config('settings.locale.default_language_id'));

    }

    public function descriptions()
    {
        return $this->hasMany(ProvinceDescription::class, 'province_id');
    }
}
