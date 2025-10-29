<?php


namespace App\Helpers;

use App\Models\Currency;
use App\Models\Location;
use App\Models\Option;
use App\Models\PaymentMethod;
use App\Models\Segment;
use App\Models\ShippingMethod;
use App\Models\StockStatus;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;
class CacheForever
{
    public static $keys_to_update = [];


    public static function rememberForever(array $tags, string $key, callable $callback)
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $prev_function = $backtrace[1]['function'] ?? 'unknown';
        $prev_function_args = isset($backtrace[1]['args']) ? serialize($backtrace[1]['args']) : '';

        self::$keys_to_update[] = "('$key', '$prev_function', '$prev_function_args')";

        return Cache::rememberForever($key, $callback);
    }

    public static function getCategories()
    {
        $cacheKey = 'categories_' . config('settings.locale.default_language_id');

        return self::rememberForever(
            ['categories'],
            $cacheKey,
            function () {
                return Category::getCategories();
            }
        );
    }
    public static function getSegments()
    {
        $cacheKey = 'segments_' . config('settings.locale.default_language_id');

        return self::rememberForever(
            ['segments'],
            $cacheKey,
            function () {
                return Segment::getSegments();
            }
        );
    }

    public static function getPaymentMethods()
    {
        $cacheKey = 'payment_methods_' . config('settings.locale.default_language_id');

        return self::rememberForever(
            ['payment_methods'],
            $cacheKey,
            function () {
                return PaymentMethod::getPaymentMethods();
            }
        );
    }

    public static function getShippingMethods()
    {
        $cacheKey = 'shipping_methods_' . config('settings.locale.default_language_id');

        return self::rememberForever(
            ['shipping_methods'],
            $cacheKey,
            function () {
                return ShippingMethod::getShippingMethods();
            }
        );
    }
    public static function getLocations()
    {
        $cacheKey = 'locations_' . config('settings.locale.default_language_id');

        return self::rememberForever(
            ['locations'],
            $cacheKey,
            function () {
                return Location::getAll()->keyBy('id');
            }
        );
    }

    public static function getOptions()
    {
        $cacheKey = 'options_' . config('settings.locale.default_language_id');

        return self::rememberForever(
            ['options'],
            $cacheKey,
            function () {
                return Option::getAll()->keyBy('id');
            }
        );
    }

    public static function getCurrencies()
    {
        return self::rememberForever(
            ['currencies'],
            'currencies',
            function () {
                return Currency::getAll();
            }
        );
    }
    public static function getStockStatuses()
    {
        $cacheKey = 'stock_statuses_' . config('settings.locale.default_language_id');

        return self::rememberForever(
            ['stock_statuses'],
            $cacheKey,
            function () {
                return StockStatus::getStockStatuses();
            }
        );
    }
}
