<?php

namespace EscolaLms\Tracker;

use EscolaLms\Tracker\Http\Middleware\TrackRouteMiddleware;
use EscolaLms\Tracker\Repositories\Contracts\TrackRouteRepositoryContract;
use EscolaLms\Tracker\Repositories\TrackRouteRepository;
use EscolaLms\Tracker\Services\Contracts\TrackRouteServiceContract;
use EscolaLms\Tracker\Services\TrackRouteService;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;

/**
 * SWAGGER_VERSION
 */
class EscolaLmsTrackerServiceProvider extends ServiceProvider
{
    public const CONFIG_KEY = 'escolalms_tracker';

    public const SERVICES = [
        TrackRouteServiceContract::class => TrackRouteService::class,
    ];

    public const REPOSITORIES = [
        TrackRouteRepositoryContract::class => TrackRouteRepository::class,
    ];

    public $singletons = self::SERVICES + self::REPOSITORIES;

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', self::CONFIG_KEY);

        $this->app->register(AuthServiceProvider::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        if (config(self::CONFIG_KEY . '.enabled')) {
            $this->app->make(Kernel::class)
                ->pushMiddleware(TrackRouteMiddleware::class);
        }
    }

    public function bootForConsole()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__ . '/config.php' => config_path(self::CONFIG_KEY . '.php'),
        ], self::CONFIG_KEY . '.config');
    }
}
