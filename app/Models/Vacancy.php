<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vacancy extends Model
{
    public $table = 'vacancies';

    public $fillable = [
        'location_id',
        'payment',
        'phone',
        'status'
    ];

    protected $casts = [
        'payment' => 'string',
        'phone' => 'string',
        'status' => 'boolean'
    ];

    public static array $rules = [
        'location_id' => 'required',
        'payment' => 'required|string|max:255',
        'phone' => 'required|string|max:255',
        'status' => 'required|boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'vacancy_descriptions');
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(VacancyDescription::class, 'vacancy_id');
    }
}
