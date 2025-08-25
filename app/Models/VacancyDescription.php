<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;

class VacancyDescription extends Model
{
    use HasCompositeKey;

    public $table = 'vacancy_descriptions';
    public $timestamps = false;

    protected $primaryKey = ['vacancy_id', 'language_id'];

    public $fillable = [
        'language_id',
        'title',
        'description',
        'name_contact_person'
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'name_contact_person' => 'string'
    ];

    public static array $rules = [
        'language_id' => 'required',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'name_contact_person' => 'required|string|max:255'
    ];

    public function language(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Language::class, 'language_id');
    }

    public function vacancy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Vacancy::class, 'vacancy_id');
    }
}
