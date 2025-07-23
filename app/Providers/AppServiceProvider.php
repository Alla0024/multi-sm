<?php

namespace App\Providers;

use App\Doctrine\Types\BonusProgramsType;
use Doctrine\DBAL\Exception;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Doctrine\DBAL\Types\Type;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     * @throws Exception
     */
    public function boot(): void
    {
        if (!Type::hasType('bonus_programs_type')) {
            Type::addType('bonus_programs_type', BonusProgramsType::class);
        }

        $platform = DB::connection()->getDoctrineConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('bonus_programs_type', 'bonus_programs_type');

        App::setLocale('uk');
    }
}
