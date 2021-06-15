<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TinnyApi\Contracts\UserRepository;
use TinnyApi\DBConnection\MySQLConnectionFactory as MysqlConnection;
use TinnyApi\DBConnection\SQLiteConnectionFactory as SQLiteConnection;
use TinnyApi\Repositories\UserEloquentRepository;
use TinnyApi\Models\UserModel;
use TinnyApi\Rules\WeakPasswordRule;

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
        $this->app->singleton(MysqlConnection::class, function ($app) {
            return new MysqlConnection($app['db']);
        });

        $this->app->singleton(SQLiteConnection::class, function ($app) {
            return new SQLiteConnection($app['db']);
        });

        $this->app->singleton(UserRepository::class, function () {
            return new UserEloquentRepository(new UserModel());
        });

        $this->app->singleton(WeakPasswordRule::class, function ($app) {
            return new WeakPasswordRule($app['cache.store']);
        });
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
