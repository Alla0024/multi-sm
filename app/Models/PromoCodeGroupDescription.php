<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromoCodeGroupDescription extends Model
{
    public $table = 'promo_code_group_descriptions';

    public $fillable = [
        'promo_code_group_id',
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
        'promo_code_group_id' => 'required',
        'language_id' => 'required',
        'name' => 'required|string|max:255',
        'image' => 'nullable|string|max:255',
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:65535'
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function promoCodeGroup(): BelongsTo
    {
        return $this->belongsTo(PromoCodeGroup::class, 'promo_code_group_id');
    }
}
