<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TinnyApi\Contracts\UserRepository;
use TinnyApi\DBConnection\MySQLConnectionFactory as MysqlConnection;
use TinnyApi\DBConnection\SQLiteConnectionFactory as SQLiteConnection;
use TinnyApi\Models\UserModel;
use TinnyApi\Repositories\UserEloquentRepository;
use TinnyApi\Requests\PasswordUpdateRequest;
use TinnyApi\Requests\UserUpdateRequest;
use TinnyApi\Rules\CurrentPasswordRule;
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

        $this->app->singleton(UserRepository::class, function ($app) {
            return new UserEloquentRepository(new UserModel(), $app['cache.store']);
        });

        $this->app->singleton(WeakPasswordRule::class, function ($app) {
            return new WeakPasswordRule($app['cache.store']);
        });

        $this->app->singleton(CurrentPasswordRule::class, function ($app) {
            return new CurrentPasswordRule($app['hash'], $app['auth.driver']);
        });

        $this->app->singleton(PasswordUpdateRequest::class, function ($app) {
            return tap(new PasswordUpdateRequest(), function ($instance) use ($app) {
                $instance->setCurrentPasswordRuleInstance($app[CurrentPasswordRule::class]);
                $instance->setWeakPasswordRuleInstance($app[WeakPasswordRule::class]);
            });
        });

        $this->app->singleton(UserUpdateRequest::class, function () {
            return new UserUpdateRequest();
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
