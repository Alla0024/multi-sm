<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public $table = 'languages';
    public $timestamps = false;

    public $fillable = [
        'code',
        'path',
        'status',
        'title',
        'sort_order'
    ];

    protected $casts = [
        'code' => 'string',
        'path' => 'string',
        'title' => 'string',
        'status' => 'integer',
        'sort_order' => 'integer'
    ];

    public static array $rules = [
        'code' => 'required|max:5',
        'path' => 'nullable|max:5',
        'title' => 'required',
        'status' => 'required',
        'sort_order' => 'required'
    ];

}
