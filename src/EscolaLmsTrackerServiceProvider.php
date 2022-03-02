<?php

namespace EscolaLms\Tracker;

use Illuminate\Support\ServiceProvider;

/**
 * SWAGGER_VERSION
 */
class EscolaLmsTrackerServiceProvider extends ServiceProvider
{
    const CONFIG_KEY = 'escolalms_tracker';

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
    }

    public function bootForConsole()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__ . '/config.php' => config_path(self::CONFIG_KEY . '.php'),
        ], self::CONFIG_KEY . '.config');
    }
}
