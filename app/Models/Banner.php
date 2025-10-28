<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public $table = 'banners';

    public $fillable = [
        'link',
        'status',
        'banner_group_id',
        'sort_order',
        'datetime_start',
        'datetime_end'
    ];

    protected $casts = [
        'link' => 'string',
        'datetime_start' => 'datetime',
        'datetime_end' => 'datetime'
    ];

    public static array $rules = [
        'link' => 'required|string|max:255',
        'status' => 'required',
        'banner_group_id' => 'required',
        'sort_order' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'datetime_start' => 'required',
        'datetime_end' => 'required'
    ];

    public function descriptions()
    {
        return $this->hasMany(BannerDescription::class, 'banner_id');
    }
    public function bannerDescriptions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\BannerDescription::class, 'banner_id');
    }

    public function bannerToCategory(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\BannerToCategory::class);
    }
}
