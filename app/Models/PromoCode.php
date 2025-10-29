<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    public $table = 'promo_codes';

    public $fillable = [
        'status',
        'sort_order',
        'code',
        'value',
        'change_number',
        'type_number',
        'promo_code_group_id',
        'number_of_uses',
        'date_start',
        'date_end'
    ];

    protected $casts = [
        'status' => 'string',
        'code' => 'string',
        'value' => 'float',
        'type_number' => 'string',
        'date_start' => 'datetime',
        'date_end' => 'datetime'
    ];

    public static array $rules = [
        'status' => 'required|string|max:255',
        'sort_order' => 'nullable',
        'code' => 'required|string|max:255',
        'value' => 'nullable|numeric',
        'change_number' => 'nullable',
        'type_number' => 'nullable|string|max:255',
        'promo_code_group_id' => 'required',
        'number_of_uses' => 'required',
        'date_start' => 'nullable',
        'date_end' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
    public function description()
    {
        return $this->hasOne(PromoCodeDescription::class, 'promo_code_id')
            ->where('language_id', config('settings.locale.default_language_id'));

    }

    public function descriptions()
    {
        return $this->hasMany(PromoCodeDescription::class, 'promo_code_id');
    }

    public function promoCodeGroup()
    {
        return $this->belongsTo(PromoCodeGroup::class, 'promo_code_group_id');
    }

    public function languages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Language::class, 'promo_code_descriptions');
    }
}
