<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerToCategory extends Model
{
    public $timestamps = false;

    protected $table = 'banner_to_categories';

    public static function getCategoryIds($banner_id)
    {
        return self::where('banner_id', $banner_id)->pluck('category_id')->all();
    }
}
