<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerDescription extends Model
{
    public $table = 'banner_descriptions';

    public $fillable = [
        'banner_id',
        'language_id',
        'image',
        'title'
    ];

    protected $casts = [
        'image' => 'string',
        'title' => 'string'
    ];

    public static array $rules = [
        'banner_id' => 'required',
        'language_id' => 'required',
        'image' => 'required|string|max:255',
        'title' => 'required|string|max:255'
    ];

    public function banner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Banner::class, 'banner_id');
    }
}
