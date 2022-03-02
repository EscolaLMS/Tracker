<?php

namespace EscolaLms\Tracker;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
    ];

    public function boot()
    {
        $this->registerPolicies();

        if (!$this->app->routesAreCached()) {
            Passport::routes();
        }
    }
}
