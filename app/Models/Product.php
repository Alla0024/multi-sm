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
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Currency::class, 'currency_id');
    }

    public function stockStatus(): BelongsTo
    {
        return $this->belongsTo(\App\Models\StockStatus::class, 'stock_status_id');
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
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }

    //    public function id82ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\82ProductPrice::class, 'product_id');
    //    }

    //    public function id63ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\63ProductPriceToFilter::class);
    //    }

    //    public function id92ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\92ProductPriceToOption::class);
    //    }

    //    public function id92ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\92ProductPrice::class, 'product_id');
    //    }

    //    public function id92ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\92ProductPriceToFilter::class);
    //    }

    //    public function id88ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\88ProductPriceToOption::class);
    //    }

    //    public function id88ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\88ProductPrice::class, 'product_id');
    //    }

    //    public function id88ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\88ProductPriceToFilter::class);
    //    }

    //    public function id86ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\86ProductPriceToOption::class);
    //    }

    //    public function id86ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\86ProductPrice::class, 'product_id');
    //    }

    //    public function id82ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\82ProductPriceToOption::class);
    //    }

    //    public function id60ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\60ProductPrice::class, 'product_id');
    //    }

    //    public function id86ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\86ProductPriceToFilter::class);
    //    }

    //    public function id160ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\160ProductPriceToOption::class);
    //    }

    //    public function id85ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\85ProductPriceToOption::class);
    //    }

    //    public function id160ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\160ProductPrice::class, 'product_id');
    //    }

    //    public function id63ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\63ProductPrice::class, 'product_id');
    //    }

    //    public function id59ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\59ProductPrice::class, 'product_id');
    //    }

    //    public function id85ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\85ProductPrice::class, 'product_id');
    //    }

    //    public function id85ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\85ProductPriceToFilter::class);
    //    }

    //    public function id84ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\84ProductPriceToOption::class);
    //    }

    //    public function id84ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\84ProductPrice::class, 'product_id');
    //    }

    //    public function id160ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\160ProductPriceToFilter::class);
    //    }

    //    public function id84ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\84ProductPriceToFilter::class);
    //    }

    //    public function id83ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\83ProductPriceToOption::class);
    //    }

    //    public function id83ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\83ProductPrice::class, 'product_id');
    //    }

    //    public function id83ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\83ProductPriceToFilter::class);
    //    }

    //    public function id158ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\158ProductPriceToOption::class);
    //    }

    //    public function id158ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\158ProductPrice::class, 'product_id');
    //    }

    //    public function id158ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\158ProductPriceToFilter::class);
    //    }

    //    public function id156ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\156ProductPriceToOption::class);
    //    }

    //    public function id156ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\156ProductPrice::class, 'product_id');
    //    }

    //    public function id156ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\156ProductPriceToFilter::class);
    //    }

    //    public function id155ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\155ProductPriceToOption::class);
    //    }

    //    public function id155ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\155ProductPrice::class, 'product_id');
    //    }

    //    public function id155ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\155ProductPriceToFilter::class);
    //    }

    //    public function id63ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\63ProductPriceToOption::class);
    //    }

    //    public function id59ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\59ProductPriceToFilter::class);
    //    }

    //    public function id145ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\145ProductPriceToOption::class);
    //    }

    //    public function id145ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\145ProductPrice::class, 'product_id');
    //    }

    //    public function id145ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\145ProductPriceToFilter::class);
    //    }

    //    public function id177ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\177ProductPriceToOption::class);
    //    }

    //    public function id142ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\142ProductPriceToOption::class);
    //    }

    //    public function id142ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\142ProductPrice::class, 'product_id');
    //    }

    //    public function id142ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\142ProductPriceToFilter::class);
    //    }

    //    public function id129ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\129ProductPriceToOption::class);
    //    }

    //    public function id129ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\129ProductPrice::class, 'product_id');
    //    }

    //    public function id129ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\129ProductPriceToFilter::class);
    //    }

    //    public function id128ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\128ProductPriceToOption::class);
    //    }

    //    public function id128ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\128ProductPrice::class, 'product_id');
    //    }

    //    public function id75ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\75ProductPriceToFilter::class);
    //    }

    //    public function id61ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\61ProductPriceToFilter::class);
    //    }

    //    public function id75ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\75ProductPrice::class, 'product_id');
    //    }

    public function category1s(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Category::class, 'top_sales');
    }

    //    public function id177ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\177ProductPrice::class, 'product_id');
    //    }

    public function shippingMethods(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\ShippingMethod::class, 'shipping_method_to_products');
    }

    //    public function id177ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\177ProductPriceToFilter::class);
    //    }

    public function segments(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Segment::class, 'segment_to_products');
    }

    public function saleToProduct(): HasOne
    {
        return $this->hasOne(\App\Models\SaleToProduct::class);
    }

    //    public function id60ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\60ProductPriceToOption::class);
    //    }

    //    public function id75ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\75ProductPriceToOption::class);
    //    }

    //    public function id176ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\176ProductPriceToOption::class);
    //    }

    //    public function id80ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\80ProductPriceToFilter::class);
    //    }

    //    public function id176ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\176ProductPrice::class, 'product_id');
    //    }

    //    public function id80ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\80ProductPrice::class, 'product_id');
    //    }

    //    public function id176ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\176ProductPriceToFilter::class);
    //    }

    public function promoCodeGroups(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\PromoCodeGroup::class, 'promo_code_group_to_products');
    }

    public function promoCodeGroup2s(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\PromoCodeGroup::class, 'promo_code_group_to_exception_products');
    }

    //    public function id175ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\175ProductPriceToOption::class);
    //    }

    //    public function id61ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\61ProductPrice::class, 'product_id');
    //    }

    public function productToYoutubes(): HasMany
    {
        return $this->hasMany(\App\Models\ProductToYoutube::class, 'product_id');
    }

    public function productSimilar(): HasOne
    {
        return $this->hasOne(\App\Models\ProductSimilar::class);
    }

    public function productSimilar3s(): HasMany
    {
        return $this->hasMany(\App\Models\ProductSimilar::class, 'similar_id');
    }

    public function productReviews(): HasMany
    {
        return $this->hasMany(\App\Models\ProductReview::class, 'product_id');
    }

    public function productRelated(): HasOne
    {
        return $this->hasOne(\App\Models\ProductRelated::class);
    }

    public function productRelated4s(): HasMany
    {
        return $this->hasMany(\App\Models\ProductRelated::class, 'related_id');
    }

    //    public function id60ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\60ProductPriceToFilter::class);
    //    }

    public function productOversizes(): HasMany
    {
        return $this->hasMany(\App\Models\ProductOversize::class, 'product_id');
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

    //    public function id175ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\175ProductPrice::class, 'product_id');
    //    }

    public function productKits(): HasMany
    {
        return $this->hasMany(\App\Models\ProductKit::class, 'kit_product_id');
    }

    public function productKit5s(): HasMany
    {
        return $this->hasMany(\App\Models\ProductKit::class, 'product_id');
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(\App\Models\ProductImage::class, 'product_id');
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

    //    public function id80ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\80ProductPriceToOption::class);
    //    }

    //    public function id175ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\175ProductPriceToFilter::class);
    //    }

    public function productAttributeIcon(): HasOne
    {
        return $this->hasOne(\App\Models\ProductAttributeIcon::class);
    }

    public function productAttributes(): HasMany
    {
        return $this->hasMany(\App\Models\ProductAttribute::class, 'product_id');
    }

    //    public function id172ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\172ProductPriceToOption::class);
    //    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Order::class, 'order_products');
    }

    public function orderOptionProducts(): HasMany
    {
        return $this->hasMany(\App\Models\OrderOptionProduct::class, 'product_id');
    }

    //    public function id172ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\172ProductPrice::class, 'product_id');
    //    }

    //    public function id172ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\172ProductPriceToFilter::class);
    //    }

    public function news(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\News::class, 'new_to_products');
    }

    //    public function id171ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\171ProductPriceToOption::class);
    //    }

    //    public function id81ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\81ProductPriceToFilter::class);
    //    }

    //    public function id171ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\171ProductPrice::class, 'product_id');
    //    }

    public function loggingCheckoutActionToProducts(): HasMany
    {
        return $this->hasMany(\App\Models\LoggingCheckoutActionToProduct::class, 'product_id');
    }

    //    public function id81ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\81ProductPrice::class, 'product_id');
    //    }

    //    public function id171ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\171ProductPriceToFilter::class);
    //    }

    public function kit6s(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Kit::class, 'kit_products');
    }

    //    public function id164ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\164ProductPriceToOption::class);
    //    }

    //    public function id164ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\164ProductPrice::class, 'product_id');
    //    }

    //    public function id61ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\61ProductPriceToOption::class);
    //    }

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

    //    public function id59ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\59ProductPriceToOption::class);
    //    }

    //    public function id128ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\128ProductPriceToFilter::class);
    //    }

    //    public function id81ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\81ProductPriceToOption::class);
    //    }

    //    public function id164ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\164ProductPriceToFilter::class);
    //    }

    //    public function id82ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\82ProductPriceToFilter::class);
    //    }

    //    public function id161ProductPriceToOption(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\161ProductPriceToOption::class);
    //    }

    //    public function id161ProductPrices(): HasMany
    //    {
    //        return $this->hasMany(\App\Models\161ProductPrice::class, 'product_id');
    //    }

    public function bankProgramToProducts(): HasMany
    {
        return $this->hasMany(\App\Models\BankProgramToProduct::class, 'product_id');
    }

    //    public function id161ProductPriceToFilter(): HasOne
    //    {
    //        return $this->hasOne(\App\Models\161ProductPriceToFilter::class);
    //    }

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

    public function seoPath()
    {
        return $this->hasOne(FirstPathQuery::class, 'type_id')->where('type', 'product');
    }
}
