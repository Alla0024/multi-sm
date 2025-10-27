<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    public $table = 'products';

    public $fillable = [
        'article',
        'manufacturer_id',
        'category_id',
        'stock_status_id',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'article' => 'string',
        'hash' => 'string',
        'sku' => 'string',
        'rating' => 'float',
        'name_in_1c' => 'string',
        'image' => 'string',
        'image_path' => 'string',
        'show_in_stock' => 'boolean',
        'show_count_viewers' => 'boolean',
        'mini_images' => 'string'
    ];

    public static array $rules = [
        'article' => 'required|string|max:50',
        'hash' => 'required|string|max:255',
        'sku' => 'required|string|max:255',
        'kit' => 'nullable',
        'currency_id' => 'required',
        'manufacturer_id' => 'required',
        'category_id' => 'required',
        'kit_id' => 'nullable',
        'stock_status_id' => 'required',
        'sort_order' => 'required',
        'status' => 'required',
        'rozetka_status' => 'required',
        'google_remarketing_status' => 'required',
        'rating' => 'required|numeric',
        'reviews' => 'required',
        'location_id' => 'nullable',
        'name_in_1c' => 'nullable|string|max:255',
        'copy' => 'nullable',
        'image' => 'nullable|string|max:255',
        'image_path' => 'nullable|string|max:255',
        'viewers_number_from' => 'nullable',
        'viewers_number_to' => 'nullable',
        'show_in_stock' => 'required|boolean',
        'show_count_viewers' => 'required|boolean',
        'mini_images' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'mark' => 'nullable',
        'cashback' => 'required'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id')->with('description');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Currency::class, 'currency_id');
    }

    public function stockStatus(): BelongsTo
    {
        return $this->belongsTo(\App\Models\StockStatus::class, 'stock_status_id')->with('description');
    }

    public function kit(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Kit::class, 'kit_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_id');
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id')->with('description');
    }

    public function category1s(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Category::class, 'top_sales');
    }

    public function shippingMethods(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\ShippingMethod::class, 'shipping_method_to_products');
    }

    public function saleToProduct(): HasOne
    {
        return $this->hasOne(\App\Models\SaleToProduct::class);
    }

    public function promoCodeGroups(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\PromoCodeGroup::class, 'promo_code_group_to_products');
    }

    public function promoCodeGroup2s(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\PromoCodeGroup::class, 'promo_code_group_to_exception_products');
    }

    public function productToYoutubes(): HasMany
    {
        return $this->hasMany(\App\Models\ProductToYoutube::class, 'product_id');
    }

//    public function productSimilar(): HasOne
//    {
//        return $this->hasOne(\App\Models\ProductSimilar::class);
//    }

    public function productSimilar3s(): HasMany
    {
        return $this->hasMany(\App\Models\ProductSimilar::class, 'similar_id');
    }

    public function productReviews(): HasMany
    {
        return $this->hasMany(\App\Models\ProductReview::class, 'product_id');
    }

    public function productRelated()
    {
        return $this->hasOne(ProductRelated::class)->with('description');
    }

    public function productRelated4s(): HasMany
    {
        return $this->hasMany(\App\Models\ProductRelated::class, 'related_id');
    }

    public function productOversizes(): HasMany
    {
        return $this->hasMany(ProductOversize::class, 'product_id')->distinct();
    }

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Option::class, 'product_options');
    }

    public function productOptionValueToOptionValueGroup(): HasOne
    {
        return $this->hasOne(\App\Models\ProductOptionValueToOptionValueGroup::class);
    }

    public function productOptionValueGroup(): HasOne
    {
        return $this->hasOne(\App\Models\ProductOptionValueGroup::class);
    }

    public function productOptionDescription(): HasOne
    {
        return $this->hasOne(\App\Models\ProductOptionDescription::class);
    }

    public function productKits(): HasMany
    {
        return $this->hasMany(\App\Models\ProductKit::class, 'kit_product_id');
    }

    public function productKit5s(): HasMany
    {
        return $this->hasMany(\App\Models\ProductKit::class, 'product_id');
    }

    public function productHash(): HasOne
    {
        return $this->hasOne(\App\Models\ProductHash::class);
    }

    public function productFilter(): HasOne
    {
        return $this->hasOne(\App\Models\ProductFilter::class);
    }

    public function productDescriptions(): HasMany
    {
        return $this->hasMany(\App\Models\ProductDescription::class, 'product_id');
    }

    public function productCertificates(): HasMany
    {
        return $this->hasMany(\App\Models\ProductCertificate::class, 'product_id');
    }

    public function productAttributeIcon(): HasOne
    {
        return $this->hasOne(\App\Models\ProductAttributeIcon::class);
    }

    public function productAttributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class, 'product_id')->with('descriptions', 'words');
    }
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Order::class, 'order_products');
    }

    public function orderOptionProducts(): HasMany
    {
        return $this->hasMany(\App\Models\OrderOptionProduct::class, 'product_id');
    }

    public function news(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\News::class, 'new_to_products');
    }

    public function loggingCheckoutActionToProducts(): HasMany
    {
        return $this->hasMany(\App\Models\LoggingCheckoutActionToProduct::class, 'product_id');
    }

    public function kit6s(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Kit::class, 'kit_products');
    }

    public function companionProducts(): HasMany
    {
        return $this->hasMany(\App\Models\CompanionProduct::class, 'companion_id');
    }

    public function companionProduct7s(): HasMany
    {
        return $this->hasMany(\App\Models\CompanionProduct::class, 'product_id');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(\App\Models\Cart::class, 'product_id');
    }

    public function bankProgramToProducts(): HasMany
    {
        return $this->hasMany(\App\Models\BankProgramToProduct::class, 'product_id');
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(ProductDescription::class, 'product_id');
    }
    public function description(): HasOne
    {
        return $this->hasOne(ProductDescription::class, 'product_id')->where('language_id', config('settings.locale.default_language_id'));
    }

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class, ProductToStore::class);
    }

    public function segments(): BelongsToMany
    {
        return $this->belongsToMany(Segment::class, SegmentToProduct::class)->with('description');
    }

    public function seoPath()
    {
        return $this->hasOne(FirstPathQuery::class, 'type_id')->where('type', 'product');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }
    public function filters()
    {
        return $this->belongsToMany(Filter::class, ProductFilter::class)->with('description');
    }
    public function icons()
    {
        return $this->hasMany(ProductAttributeIcon::class);
    }

    public function optionValueGroups()
    {
        return $this->hasMany(ProductOptionValueGroup::class)->with( 'optionValueGroup');
    }

    public function productOptions()
    {
        return $this->hasMany(ProductOption::class)->with('option');
    }
    public function productOptionValues()
    {
        return $this->hasMany(ProductOptionValueToOptionValueGroup::class)->with('option_value');
    }
    public function videos()
    {
        return $this->hasMany(ProductToYoutube::class);
    }
    public function companions()
    {
        return $this->hasMany(CompanionProduct::class)->with('description');
    }

    public function similarProducts()
    {
        return $this->hasMany(ProductSimilar::class)->with('description', 'product')->orderBy('sort_order');
    }
    public function certificates()
    {
        return $this->hasMany(ProductCertificate::class);
    }
    public function filling()
    {
        return $this->hasMany(ProductFilling::class)->with('description');
    }
    public function kitProducts()
    {
        return $this->hasMany(ProductKit::class)->with('description', 'kitProduct');
    }
}
