<?php

namespace EscolaLms\Tracker;

use EscolaLms\Tracker\Models\TrackRoute;
use EscolaLms\Tracker\Policies\TrackRoutePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        TrackRoute::class => TrackRoutePolicy::class
    ];

    public function boot()
    {
        $this->registerPolicies();

        if (!$this->app->routesAreCached() && method_exists(Passport::class, 'routes')) {
            Passport::routes();
        }
    }
}
