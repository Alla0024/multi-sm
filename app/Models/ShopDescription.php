<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopDescription extends Model
{
    public $table = 'shop_descriptions';

    public $fillable = [
        'language_id',
        'name',
        'address',
        'schedule',
        'schedule_temporary',
        'description',
        'sale',
        'image_banner'
    ];

    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'schedule' => 'string',
        'schedule_temporary' => 'string',
        'description' => 'string',
        'sale' => 'string',
        'image_banner' => 'string'
    ];

    public static array $rules = [
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:65535',
        'schedule' => 'required|string|max:65535',
        'schedule_temporary' => 'nullable|string|max:65535',
        'description' => 'required|string|max:255',
        'sale' => 'required|string|max:65535',
        'image_banner' => 'required|string|max:255'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
