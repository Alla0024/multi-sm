<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformationDescription extends Model
{
    public $table = 'information_descriptions';

    public $fillable = [
        'language_id',
        'name',
        'description'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string'
    ];

    public static array $rules = [
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'description' => 'required|string'
    ];

    public function information()
    {
        return $this->belongsTo(Information::class, 'information_id');
    }
}
