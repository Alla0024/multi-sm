<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
class Store extends Model
{
    use HasFactory;

    public $table = 'stores';

    public $fillable = [
        'name',
        'url',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'name' => 'string',
        'url' => 'string'
    ];

    public static array $rules = [
        'name' => 'required',
        'url' => 'required|url'
    ];


}
