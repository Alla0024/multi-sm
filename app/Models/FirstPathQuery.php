<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirstPathQuery extends Model
{
    public $table = 'first_path_queries';

    public $fillable = [
        'type',
        'type_id',
        'path'
    ];

    protected $casts = [
        'type' => 'string',
        'path' => 'string'
    ];

    public static array $rules = [
        'type' => 'required|string|max:255',
        'type_id' => 'required',
        'path' => 'required|string|max:255'
    ];

    
}
