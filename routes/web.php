<?php


use App\Http\Controllers\pages\ExampleController;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\DashboardController;

Route::get('map_data_{lang}.json', function ($lang = '') {
    header('Content-Type: application/json', true);
    echo Storage::disk('public')->get('map_data_' . $lang . '.json');
});

Route::get('watch', 'Content\WatchDbController@get');
Route::post('watch', 'Content\WatchDbController@post');
Route::group(['prefix' => env('ADMIN_DASHBOARD', 'aikqweu')], function () {
    Auth::routes();
    Route::get('api/closed-info-sales', 'SaleController@index');
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('example', [ExampleController::class, 'index']);
        Route::get('example/edit', [ExampleController::class, 'edit']);

        Route::group(['prefix' => 'settings'], function () {
            Route::resource('languages', 'Settings\LanguageController');
            Route::resource('individual_entrepreneurs', 'Settings\IndividualEntrepreneurController');
            Route::resource('stock_statuses', 'Settings\StockStatusController');
            Route::get('/all_update_currencies', 'Settings\CurrencyController@allUpdateCurrencies')->name('all_update_currencies');
            Route::resource('currencies', 'Settings\CurrencyController');
            Route::resource('regions', 'Settings\RegionController');
            Route::resource('locations', 'Settings\LocationController');
            Route::resource('settings', 'Settings\SettingController');
            Route::resource('pages', 'Settings\PageController');
        });
        Route::resource('languages', 'App\Http\Controllers\Content\LanguageController');
        Route::resource('stores', 'App\Http\Controllers\Content\StoreController');
        Route::get('bitrix', 'Bitrix24RestApi@UpBitrixInfo')->name('bitrix');
        Route::resource('manufacturers', 'Content\ManufacturerController');
        Route::resource('seodata', 'Content\SeoDataController');
        Route::resource('informations', 'Content\InformationController');
        Route::resource('shipping_methods', 'Content\ShippingController');
        Route::resource('filters', 'Content\FilterController');
        Route::resource('attributes', 'Content\AttributeController');
        Route::resource('attribute_groups', 'Content\AttributeGroupController');
        Route::resource('attribute_words', 'Content\AttributeWordController');
        Route::resource('attribute_icons', 'Content\AttributeIconController');
        Route::resource('options', 'Content\OptionController');
        Route::get('fiscalization', 'Content\FiscalizationController@index')->name('fiscalization');
        Route::resource('option_values', 'Content\OptionValueController');
        Route::resource('categories', 'Content\CategoryController');
        Route::resource('products', 'Content\ProductController');
        Route::resource('panoramas', 'Content\PanoramaController');
        Route::resource('reviews', 'Content\ReviewController');
        Route::resource('sales', 'Content\SaleController');
        Route::resource('sale_groups', 'Content\SaleGroupController');
        Route::resource('bonus_programs', 'Content\BonusProgramController');
        Route::resource('segments', 'Content\SegmentController');
        Route::resource('promo_codes', 'Content\PromoCodesController');
        Route::resource('promo_code_groups', 'Content\PromoCodeGroupsController');
        Route::resource('shops', 'Content\ShopController');
        Route::resource('orders', 'Content\OrderController');
        Route::resource('notifications', 'Content\NotificationController');
        Route::resource('banners', 'Content\BannerController');
        Route::resource('banner_groups', 'Content\BannerGroupController');
        Route::resource('stocks', 'Content\StockController');

        Route::resource('questions', 'Content\QuestionController');
        Route::resource('answers', 'Content\AnswerController');
        Route::resource('news', 'Content\NewsController');
        Route::resource('article_authors', 'Content\ArticleAuthorController');
        Route::resource('vacancies', 'Content\VacancyController');
        Route::resource('filling', 'Content\FillingController');
        Route::resource('services', 'Content\ServiceController');
        Route::resource('kit', 'Content\KitController');
        Route::resource('newsletters', 'Content\NewsletterController');
        Route::get('newsletters_start', 'Content\NewsletterController@start');
        Route::resource('receipts', 'Content\ReceiptController');
        Route::get('combinations/generate', [
            'as' => 'combinations.generate',
            'uses' => 'Content\ChainCombinationController@show'
        ]);
        Route::resource('combinations', 'Content\ChainCombinationController');

        Route::get('packagist/create/{id}', [
            'as' => 'packagist.create',
            'uses' => 'Content\PackagistController@create'
        ]);
        Route::get('packagist/{id}/edit', [
            'as' => 'packagist.edit',
            'uses' => 'Content\PackagistController@edit'
        ]);
        Route::post('packagist/update/', [
            'as' => 'packagist.update',
            'uses' => 'Content\PackagistController@update'
        ]);
        Route::post('packagist/store/', [
            'as' => 'packagist.store',
            'uses' => 'Content\PackagistController@store'
        ]);
        Route::post('packagist/destroy/', [
            'as' => 'packagist.destroy',
            'uses' => 'Content\PackagistController@destroy'
        ]);
        Route::post('packagist/destroyAll/', [
            'as' => 'packagist.destroy_all',
            'uses' => 'Content\PackagistController@destroyAll'
        ]);
        Route::post('packagist/updateFilters/', [
            'as' => 'packagist.update_filters',
            'uses' => 'Content\PackagistController@updateFilters'
        ]);
        Route::post('packagist/updateCache/', [
            'as' => 'packagist.update_cache',
            'uses' => 'Content\PackagistController@updateClientCache'
        ]);
        Route::get('update_price', 'Content\StockController@update_price')->name('update_price');
        Route::resource('modules', 'ModuleController');
        Route::get('extensions', 'ExtensionController@index')->name('extensions');
        Route::get('cache_clear', 'Settings\CacheClearController@index')->name('cache_clear');
        Route::any('extension/{controller}/{method?}', function ($controller, $method = null) {
            $controllerName = 'App\Http\Controllers\Extensions\\' . $controller . 'ExtensionController';
            $controller = new $controllerName;
            if ($method) {
                return $controller->{$method}();
            } else {
                return $controller->index();
            }
        })->name('extension');


        Route::get('/', function () {
            return redirect()->route('dashboard');
        });
        Route::get('/api/get_currency_privat_bank', 'ApiController@getCurrencyPrivatBank')->name('get_currency_privat_bank');
        Route::get('/api/order_confirm_url', 'ApiController@orderConfirmUrl')->name('order_confirm_url');
        Route::get('/api/check_status_liqpay', 'ApiController@checkStatusLiqpay')->name('check_status_liqpay');
        Route::get('/api/product_status_update', 'ApiController@productStatusUpdate')->name('product_status_update');
        Route::post('api/get_products', 'ApiController@getProducts')->name('get_products');
        Route::post('api/get_segment_products', 'ApiController@getSegmentProducts')->name('get_segment_products');
        Route::post('api/get_sales', 'ApiController@getSales')->name('get_sales');
        Route::post('api/get_bonus_programs', 'ApiController@getBonusPrograms')->name('get_bonus_programs');
        Route::post('api/get_promo_code_groups', 'ApiController@getPromoCodeGroups')->name('get_promo_code_groups');
        Route::post('api/get_product_to_promo_code_groups', 'ApiController@getProductToPromoCode')->name('get_product_to_promo_code_groups');
        Route::post('api/get_product_to_shipping_method', 'ApiController@getProductToShippingMethod')->name('get_product_to_shipping_method');
        Route::post('api/get_exception_product_in_promo_code_groups', 'ApiController@getExceptionProductToPromoCode')->name('get_exception_product_in_promo_code_groups');
        Route::get('api/get_shipping_methods', 'ApiController@getShippingMethods')->name('get_shipping_methods');
        Route::post('api/get_option_value_groups', 'ApiController@getOptionValueGroups')->name('get_option_value_groups');
        Route::get('api/get_option_to_filter', 'ApiController@getOptionToFilter')->name('get_option_to_filter');
        Route::get('api/get_option_groups', 'ApiController@getOptionGroups')->name('get_option_groups');
        Route::get('api/get_attributes', 'ApiController@getAttributes')->name('get_attributes');
        Route::get('api/get_news', 'ApiController@getNews')->name('get_news');
        Route::get('api/get_attribute_icons', 'ApiController@getIcons')->name('get_attribute_icons');
        Route::get('api/get_words', 'ApiController@getWords')->name('get_words');
        Route::get('api/get_attribute_words', 'ApiController@getAttributeWords')->name('get_attribute_words');
        Route::get('api/get_languages', 'ApiController@getLanguage')->name('get_languages');
        Route::get('api/get_product', 'ApiController@getProduct')->name('get_product');
        Route::get('api/get_filling', 'ApiController@getFilling')->name('get_filling');
        Route::get('api/get_combinations', 'ApiController@getCombination')->name('get_combinations');
        Route::get('api/get_orders', 'ApiController@getOrders')->name('get_orders');
        Route::get('api/get_categories', 'ApiController@getCategories')->name('get_categories');
        Route::get('api/get_news_categories', 'ApiController@getNewsCategories')->name('get_news_categories');
        Route::get('api/get_authors', 'ApiController@getAuthors')->name('get_authors');
        Route::post('copy_product', 'Content\ProductController@copyProduct')->name('copy_product');
        Route::post('copy_promo_code_group', 'Content\PromoCodeGroupsController@copyPromoCodeGroup')->name('copy_promo_code_group');
        Route::post('copy_promo_code', 'Content\PromoCodesController@copyPromoCode')->name('copy_promo_code');
        Route::post('copy_sale', 'Content\SaleController@copySale')->name('copy_sale');
        Route::post('copy_segment', 'Content\SegmentController@copySegment')->name('copy_segment');
        Route::post('change_sort_order', 'Content\ProductController@changeSortOrder')->name('change_sort_order');
        Route::post('change_sort_order_sale', 'Content\SaleController@changeSortOrder')->name('change_sort_order_sale');
        Route::post('/add-product-to-segment', 'Content\SegmentController@addProductToSegment')->name('addProductToSegment');
        Route::get('/segments/{id}/edit_segment', 'Content\SegmentController@edit_segment')->name('segments.edit_segment');
        Route::put('/segments/{id}/edit_segment', 'Content\SegmentController@update_segment')->name('segments.update_segment');

        Route::post('/remove-product-from-segment', 'Content\SegmentController@removeProductFromSegment')->name('removeProductFromSegment');
        Route::post('/add-filtered-products-to-segment/{segmentId}', 'Content\SegmentController@addFilteredProductsToSegment')
            ->name('addFilteredProductsToSegment');
        Route::post('/remove-filtered-products-from-segment/{segmentId}', 'Content\SegmentController@removeFilteredProductsFromSegment')
            ->name('removeFilteredProductsFromSegment');
        Route::get('cancel_changes', 'Content\ProductController@cancelChanges')->name('cancel_changes');
        Route::post('save_config_values', 'Extensions\CashbackProductsExtensionController@saveCashbackValues')->name('save_config_values');
        Route::get('/badReviews', 'Content\ReviewController@badReviewsIndex')->name('bad_reviews');
        Route::post('/getBadReviews', 'Content\ReviewController@getBadReviews')->name('get_bad_reviews');
        Route::group(['prefix' => 'api'], function () {
            Route::get('getManufacturers', 'Content\ManufacturerController@getManufacturers')->name('getManufacturers');
            Route::get('getKits', 'Content\KitController@getKits')->name('getKits');
            Route::get('getCategories', 'Content\CategoryController@getCategories')->name('getCategories');
            Route::get('getAttributes', 'Content\AttributeController@getAttributes')->name('getAttributes');
            Route::get('getFilters', 'Content\FilterController@getFilters')->name('getFilters');
            Route::get('getOptionValues', 'Content\OptionValueController@getOptionValues')->name('getOptionValues');
            Route::any('getSeoData', 'Content\SeoDataController@getSeoData')->name('getSeoData');
            Route::get('autoUpdatePrice', 'ApiController@autoUpdatePrice');
            Route::post('/payment/{type}/{method}', function ($type = null, $method = null) {
                switch ($type) {
                    case 'mnb':
                        $controllerName = 'App\Http\Controllers\Payments\MnbController';
                        break;
                    case 'prb':
                        $controllerName = 'App\Http\Controllers\Payments\PrbController';
                        break;
                    case 'fondy':
                        $controllerName = 'App\Http\Controllers\Payments\FondyController';
                        break;
                    case 'alfabank':
                        $controllerName = 'App\Http\Controllers\Payments\AlfaBankController';
                        break;
                    case 'mnbcheckout':
                        $controllerName = 'App\Http\Controllers\Payments\MnbCheckoutController';
                        break;
                }
                $controller = new $controllerName;
                if ($method) {
                    return $controller->{$method}();
                } else {
                    return $controller->index();
                }
            });
        });

    });
});
