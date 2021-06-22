<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use TinnyApi\Models\UserModel as User;
use TinnyApi\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::ignoreMigrations();
        Passport::personalAccessTokensExpireIn(Carbon::now()->addHours());
        Passport::refreshTokensExpireIn(Carbon::now()->addMonths(6));
    }
}
