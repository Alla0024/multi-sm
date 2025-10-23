<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Location extends Model
{
    public $table = 'locations';

    public $fillable = [
        'location_group_id',
        'type',
        'geocode',
        'path',
        'isocode',
        'hash',
        'ref',
        'indexing',
        'status',
        'delivery_file'
    ];

    protected $casts = [
        'type' => 'string',
        'geocode' => 'string',
        'path' => 'string',
        'isocode' => 'string',
        'hash' => 'string',
        'ref' => 'string',
        'delivery_file' => 'string'
    ];

    public static array $rules = [
        'location_group_id' => 'nullable',
        'type' => 'required|string|max:50',
        'geocode' => 'required|string|max:255',
        'path' => 'nullable|string|max:255',
        'isocode' => 'required|string|max:15',
        'hash' => 'required|string|max:255',
        'ref' => 'nullable|string|max:255',
        'indexing' => 'required',
        'status' => 'required',
        'delivery_file' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function locationGroup(): BelongsTo
    {
        return $this->belongsTo(LocationGroup::class, 'location_group_id');
    }

    public function vacancies(): HasMany
    {
        return $this->hasMany(Vacancy::class, 'location_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'location_id');
    }

    public function shops(): HasMany
    {
        return $this->hasMany(Shop::class, 'location_id');
    }

    public function locationDescription(): HasOne
    {
        return $this->hasOne(LocationDescription::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'location_id');
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(LocationDescription::class, 'location_id');
    }

    public function description()
    {
        return $this->hasOne(LocationDescription::class)->where('language_id', config('settings.locale.default_language_id'));
    }
}
