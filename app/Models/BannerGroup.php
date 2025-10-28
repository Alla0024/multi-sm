<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerGroup extends Model
{
    public $table = 'banner_groups';

    public $fillable = [
        'name',
        'type',
        'type_id',
        'layout',
        'width',
        'height',
        'status'
    ];

    protected $casts = [
        'name' => 'string',
        'type' => 'string',
        'type_id' => 'string',
        'layout' => 'string',
        'width' => 'string',
        'height' => 'string'
    ];

    public static array $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'type_id' => 'required|string|max:255',
        'layout' => 'required|string|max:255',
        'width' => 'nullable|string|max:255',
        'height' => 'nullable|string|max:255',
        'status' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function bannerToCategories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\BannerToCategory::class, 'banner_group_id');
    }
    public function banners()
    {
        return $this->hasMany(Banner::class,'banner_group_id','id')->with('descriptions');
    }
    public function stores()
    {
        return $this->belongsToMany(Store::class, BannerGroupToStore::class);
    }
}
