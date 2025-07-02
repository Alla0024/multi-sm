<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lang extends Model
{
    public $table = 'langs';

    public $fillable = [
        'code',
        'path',
        'status',
        'sort_order',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'code' => 'string',
        'path' => 'string',
        'status' => 'integer',
        'sort_order' => 'integer'
    ];

    public static array $rules = [
        'code' => 'required|max:5',
        'path' => 'nullable|max:5',
        'status' => 'required',
        'sort_order' => 'required'
    ];

    
}
