<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockStatus extends Model
{
    public $table = 'stock_statuses';

    public $fillable = [
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public static array $rules = [
        'status' => 'required|boolean'
    ];

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Product::class, 'stock_status_id');
    }

    public function languages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Language::class, 'stock_status_descriptions');
    }
}
