<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TinnyApi\Mysql\ConnectionFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAllServices();
    }

    private function registerAllServices()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
