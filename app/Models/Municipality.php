<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    public $table = 'municipalities';

    public $fillable = [

    ];

    protected $casts = [

    ];

    public static array $rules = [
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function description()
    {
        return $this->hasOne(MunicipalityDescription::class, 'municipality_id')
            ->where('language_id', config('settings.locale.default_language_id'));

    }

    public function descriptions()
    {
        return $this->hasMany(MunicipalityDescription::class, 'municipality_id');
    }
}
