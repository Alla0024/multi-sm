<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    public $table = 'shops';

    public $fillable = [
        'location_id',
        'geocode',
        'path',
        'path_sale',
        'phone',
        'additional_phone',
        'image',
        'postal_code',
        'fake_status',
        'status',
        'show_form',
        'birthday',
        'quarantine',
        'hash',
        'google_path',
        'date_end',
        'date_start_temporary',
        'date_end_temporary',
        'date_start'
    ];

    protected $casts = [
        'geocode' => 'string',
        'path' => 'string',
        'path_sale' => 'string',
        'phone' => 'string',
        'additional_phone' => 'string',
        'image' => 'string',
        'postal_code' => 'string',
        'show_form' => 'boolean',
        'birthday' => 'boolean',
        'quarantine' => 'boolean',
        'hash' => 'string',
        'google_path' => 'string',
        'date_end' => 'datetime',
        'date_start_temporary' => 'datetime',
        'date_end_temporary' => 'datetime',
        'date_start' => 'datetime'
    ];

    public static array $rules = [
        'location_id' => 'required',
        'geocode' => 'required|string|max:255',
        'path' => 'nullable|string|max:255',
        'path_sale' => 'required|string|max:255',
        'phone' => 'required|string|max:255',
        'additional_phone' => 'nullable|string|max:255',
        'image' => 'required|string|max:255',
        'postal_code' => 'nullable|string|max:255',
        'fake_status' => 'required',
        'status' => 'required',
        'show_form' => 'required|boolean',
        'birthday' => 'required|boolean',
        'quarantine' => 'required|boolean',
        'hash' => 'nullable|string|max:255',
        'google_path' => 'nullable|string|max:255',
        'date_end' => 'nullable',
        'date_start_temporary' => 'nullable',
        'date_end_temporary' => 'nullable',
        'date_start' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function description()
    {
        return $this->hasOne(ShopDescription::class, 'shop_id')
            ->where('language_id', config('settings.locale.default_language_id'));

    }
    public function descriptions()
    {
        return $this->hasMany(ShopDescription::class, 'shop_id');
    }
    public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_id');
    }

    public function shopDescription(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\ShopDescription::class);
    }

    public function shopImages()
    {
        return $this->hasMany(ShopImage::class, 'shop_id')->orderBy('sort_order');
    }
}
