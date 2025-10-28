<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public $table = 'currencies';

    public $fillable = [
        'code',
        'title',
        'symbol',
        'rate',
        'status'
    ];

    protected $casts = [
        'code' => 'string',
        'title' => 'string',
        'symbol' => 'string',
        'rate' => 'float'
    ];

    public static array $rules = [
        'code' => 'required|string|max:3',
        'title' => 'required|string|max:10',
        'symbol' => 'required|string|max:10',
        'rate' => 'required|numeric',
        'status' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Product::class, 'currency_id');
    }

    public static function getAll()
    {
        return self::all();
    }
}
