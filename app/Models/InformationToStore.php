<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function information(): BelongsTo
    {
        return $this->belongsTo(Information::class, 'information_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
