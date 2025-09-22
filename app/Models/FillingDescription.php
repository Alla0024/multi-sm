<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FillingDescription extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'filling_descriptions';

    public $incrementing = false;

    public $fillable = [
        'filling_id',
        'language_id',
        'name',
        'description',
        'tag'
    ];

    protected $casts = [
        'filling_id' => 'integer',
        'language_id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'tag' => 'string'
    ];

    public static array $rules = [
        'filling_id' => 'required|exists:filling,id',
        'language_id' => 'required',
        'name' => 'required',
        'tag' => 'required'
    ];
    public function filling()
    {
        return $this->belongsTo(Filling::class, 'filling_id');
    }
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
