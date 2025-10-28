<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleGroupDescription extends Model
{
    public $table = 'sale_group_descriptions';

    public $fillable = [
        'sale_group_id',
        'language_id',
        'name'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    public static array $rules = [
        'sale_group_id' => 'required',
        'language_id' => 'required',
        'name' => 'required|string|max:255'
    ];

    public function language(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Language::class, 'language_id');
    }

    public function saleGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\SaleGroup::class, 'sale_group_id');
    }
}
