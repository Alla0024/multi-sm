<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    public $table = 'categories';

    public $fillable = [
        'image',
        'full_image',
        'icon',
        'parent_id',
        'sub',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'image' => 'string',
        'full_image' => 'string',
        'icon' => 'string'
    ];

    public static array $rules = [
        'image' => 'nullable|string|max:255',
        'full_image' => 'nullable|string|max:255',
        'icon' => 'nullable|string',
        'parent_id' => 'required',
        'sub' => 'nullable',
        'sort_order' => 'required',
        'status' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function anchors(): HasMany
    {
        return $this->hasMany(Anchor::class, 'category_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function product1c(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'top_sales');
    }

    public function shippingMethods(): BelongsToMany
    {
        return $this->belongsToMany(ShippingMethod::class, 'shipping_method_to_exception_categories');
    }

    public function shippingMethod2s(): BelongsToMany
    {
        return $this->belongsToMany(ShippingMethod::class, 'shipping_method_to_categories');
    }

    public function promoCodeGroups(): BelongsToMany
    {
        return $this->belongsToMany(PromoCodeGroup::class, 'promo_code_group_to_categories');
    }

    public function paymentMethods(): BelongsToMany
    {
        return $this->belongsToMany(PaymentMethod::class, 'payment_method_to_categories');
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'category_id');
    }

    public function filterToCategories(): HasMany
    {
        return $this->hasMany(FilterToCategory::class, 'category_id');
    }

    public function favoriteProducts(): HasMany
    {
        return $this->hasMany(FavoriteProduct::class, 'category_id');
    }

    public function categoryDescription(): HasOne
    {
        return $this->hasOne(CategoryDescription::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'category_id');
    }

    public function bannerToCategories(): HasMany
    {
        return $this->hasMany(BannerToCategory::class, 'category_id');
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'attribute_to_category');
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(CategoryDescription::class, 'category_id');
    }

    public function seoPath()
    {
        return $this->hasOne(FirstPathQuery::class, 'type_id')->where('type', 'category');
    }
}
