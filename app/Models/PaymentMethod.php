<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    public $table = 'payment_methods';

    public $fillable = [
        'code',
        'minimum',
        'icon',
        'status',
        'sort_order'
    ];

    protected $casts = [
        'code' => 'string',
        'icon' => 'string'
    ];

    public static array $rules = [
        'code' => 'required|string|max:255',
        'minimum' => 'required',
        'icon' => 'nullable|string|max:65535',
        'status' => 'required',
        'sort_order' => 'required'
    ];

    public function description()
    {
        return $this->hasOne(PaymentMethodDescription::class, 'payment_method_id')
            ->where('language_id', config('settings.locale.default_language_id'));

    }

    public function descriptions()
    {
        return $this->hasMany(PaymentMethodDescription::class, 'payment_method_id');
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, PaymentMethodToStore::class);
    }
    public function bonusPrograms(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\BonusProgram::class, 'bonus_program_to_payments');
    }

    public function individualEntrepreneurs(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\IndividualEntrepreneur::class, 'individual_entrepreneur_to_payments');
    }

    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Order::class, 'payment_method_id');
    }

    public function languages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Language::class, 'payment_method_descriptions');
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Category::class, 'payment_method_to_categories');
    }

    public function promoCodeGroups(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\PromoCodeGroup::class, 'promo_code_group_to_payments');
    }

    public function receipts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Receipt::class, 'payment_id');
    }

    public function sales(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Sale::class, 'sale_to_payments');
    }

    public static function getPaymentMethods()
    {
        return self::with('description')
            ->where('status', 1)
            ->get();
    }
}
