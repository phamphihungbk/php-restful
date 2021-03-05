<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TinnyApi\User\Repository as UserRepository;
use TinnyApi\User\RepositoryContract as UserRepositoryContract;
use TinnyApi\Mysql\ConnectionFactory as MysqlConnection;
use TinnyApi\Contracts\DatabaseConnectionFactory;
use TinnyApi\SQLite\ConnectionFactory as SQLiteConnection;

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
        $this->app->singleton(UserRepository::class, function () {
            return new UserRepository();
        });

        $this->app->bind(UserRepositoryContract::class, UserRepository::class);

        $this->app->singleton(MysqlConnection::class, function ($app) {
            return new MysqlConnection($app['db']);
        });

        $this->app->singleton(SQLiteConnection::class, function ($app) {
            return new SQLiteConnection($app['db']);
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
