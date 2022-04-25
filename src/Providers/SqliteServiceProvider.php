<?php

namespace EscolaLms\Tracker\Providers;

use Illuminate\Support\ServiceProvider;

class SqliteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (config('escolalms_tracker.database.connection') === 'sqlite') {
            $databaseFile = __DIR__ . '/../../../../' . config('escolalms_tracker.database.database');

            if (!file_exists($databaseFile)) {
                file_put_contents($databaseFile, '');
            }
        }
    }

}
