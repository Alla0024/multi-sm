<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;

class LocationDescription extends Model
{
    use HasCompositeKey;

    public $table = 'location_descriptions';
    protected $primaryKey = ['location_id', 'language_id'];

    public $fillable = [
        'language_id',
        'name',
        'text',
        'case'
    ];

    protected $casts = [
        'name' => 'string',
        'text' => 'string',
        'case' => 'string'
    ];

    public static array $rules = [
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'text' => 'nullable|string',
        'case' => 'nullable|string|max:255'
    ];

    public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_id');
    }
}
