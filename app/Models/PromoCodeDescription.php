<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCodeDescription extends Model
{
    public $table = 'promo_code_descriptions';

    public $fillable = [
        'promo_code_id',
        'language_id',
        'name',
        'image',
        'title',
        'description'
    ];

    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'title' => 'string',
        'description' => 'string'
    ];

    public static array $rules = [
        'promo_code_id' => 'required',
        'language_id' => 'required',
        'name' => 'nullable|string|max:255',
        'image' => 'nullable|string|max:255',
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:65535'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class, 'promo_code_id');
    }
}
