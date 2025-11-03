<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class
SaleGroup extends Model
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

    public function closure()
    {
        return $this->hasMany(SaleGroupClosure::class, 'descendant_id');
    }

    public function ancestors()
    {
        return $this->belongsToMany(SaleGroup::class, SaleGroupClosure::class, 'descendant_id', 'ancestor_id'
        )->withPivot('depth');
    }

    public function descendants()
    {
        return $this->belongsToMany(SaleGroup::class, SaleGroupClosure::class, 'ancestor_id', 'descendant_id'
        )->withPivot('depth');
    }

    public function languages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Language::class, 'sale_group_descriptions');
    }

    public function bonusPrograms()
    {
        return $this->belongsToMany(BonusProgram::class, SaleGroupToBonusProgram::class);
    }

    public function promoCodeGroups()
    {
        return $this->belongsToMany(PromoCodeGroup::class, SaleGroupToPromoCodeGroup::class);
    }

    public function sales()
    {
        return $this->belongsToMany(Sale::class, SaleGroupToSale::class);
    }

    public function sale2s(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Sale::class, 'sale_group_to_sales_copy');
    }
}
