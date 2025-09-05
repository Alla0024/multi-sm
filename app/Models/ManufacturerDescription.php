<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManufacturerDescription extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'manufacturer_descriptions';

    public $incrementing = false;

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
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
