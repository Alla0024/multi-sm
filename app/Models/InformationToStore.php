<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformationToStore extends Model
{
    public $table = 'information_to_stores';

    public $fillable = [
        'store_id'
    ];

    protected $casts = [
        
    ];

    public static array $rules = [
        'store_id' => 'required'
    ];

    public function information(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Information::class, 'information_id');
    }

    public function store(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Store::class, 'store_id');
    }
}
