<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
class ManufacturerDescription extends Model
{
    use HasFactory;    public $table = 'manufacturer_descriptions';

    public $fillable = [
        'manufacturer_id',
        'language_id',
        'name',
        'description',
        'tag'
    ];

    protected $casts = [
        'manufacturer_id' => 'integer',
        'language_id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'tag' => 'string'
    ];

    public static array $rules = [
        'manufacturer_id' => 'required|exists:manufacturers,id',
        'language_id' => 'required',
        'name' => 'required',
        'tag' => 'required'
    ];

    
}
