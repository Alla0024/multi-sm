<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleGroup extends Model
{
    public $table = 'sale_groups';

    public $fillable = [
        'type',
        'status',
        'sort_order'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public static array $rules = [
        'type' => 'required',
        'status' => 'required|boolean',
        'sort_order' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
    public function description()
    {
        return $this->hasOne(SaleGroupDescription::class, 'sale_group_id')
            ->where('language_id', config('settings.locale.default_language_id'));

    }

    public function descriptions()
    {
        return $this->hasMany(SaleGroupDescription::class, 'sale_group_id');
    }
    public function saleGroupClosures(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\SaleGroupClosure::class, 'ancestor_id');
    }

    public function saleGroupClosure1s(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\SaleGroupClosure::class, 'descendant_id');
    }

    public function languages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Language::class, 'sale_group_descriptions');
    }

    public function bonusPrograms(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\BonusProgram::class, 'sale_group_to_bonus_programs');
    }

    public function promoCodeGroups(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\PromoCodeGroup::class, 'sale_group_to_promo_code_groups');
    }

    public function sales(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Sale::class, 'sale_group_to_sales');
    }

    public function sale2s(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Sale::class, 'sale_group_to_sales_copy');
    }
}
