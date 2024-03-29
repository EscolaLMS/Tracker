<?php

namespace EscolaLms\Tracker\Providers;

use EscolaLms\Tracker\Database\Schemas\TrackRouteSchema;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SqliteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $connection = config('escolalms_tracker.database.connection');

        if ($connection === 'sqlite' && config('escolalms_tracker.database.create')) {
            $databaseFile = config('database.connections.sqlite.database');

            if (empty($databaseFile)) {
                return;
            }

            if (!file_exists($databaseFile)) {
                file_put_contents($databaseFile, '');
                chmod($databaseFile, 0666);
            }

            if (!Cache::get('trackerSqliteCacheCheck')) {
                if (!Schema::connection($connection)->hasTable('track_routes')) {
                    Schema::connection($connection)->create('track_routes', TrackRouteSchema::schema());
                }
                Cache::put('trackerSqliteCacheCheck', true);
            }
        }
    }
}
