<?php

namespace App\Providers;

use App\Helpers\Document as DocumentHelper;
use Illuminate\Support\ServiceProvider;

class MainServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {


    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('document', function(){
            return new DocumentHelper();
        });

    }
}
