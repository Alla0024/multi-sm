<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDescription extends Model
{
    public $table = 'sale_descriptions';

    public $fillable = [
        'language_id',
        'description',
        'thumbnail',
        'image',
        'name',
        'important_info',
        'mini_description',
        'product_description',
        'big_banner',
        'small_banner'
    ];

    protected $casts = [
        'description' => 'string',
        'thumbnail' => 'string',
        'image' => 'string',
        'name' => 'string',
        'important_info' => 'string',
        'mini_description' => 'string',
        'product_description' => 'string',
        'big_banner' => 'string',
        'small_banner' => 'string'
    ];

    public static array $rules = [
        'language_id' => 'required',
        'description' => 'required|string|max:65535',
        'thumbnail' => 'required|string|max:255',
        'image' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'important_info' => 'nullable|string|max:65535',
        'mini_description' => 'nullable|string|max:65535',
        'product_description' => 'nullable|string|max:255',
        'big_banner' => 'nullable|string|max:255',
        'small_banner' => 'nullable|string|max:255'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
