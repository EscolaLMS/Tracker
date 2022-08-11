<?php

namespace EscolaLms\Tracker\Providers;

use EscolaLms\Tracker\Database\Schemas\TrackRouteSchema;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SqliteServiceProvider extends ServiceProvider
{
    public function boot()
    {

        $connection = config('escolalms_tracker.database.connection');

        if (
            config('escolalms_tracker.database.connection') === 'sqlite'
            && config('escolalms_tracker.database.create')
        ) {
            $databaseFile = config('escolalms_tracker.database.path');

            if (!file_exists($databaseFile)) {
                file_put_contents($databaseFile, '');
            }

            if (!Schema::connection($connection)->hasTable('track_routes')) {
                Schema::connection($connection)->create('track_routes', TrackRouteSchema::schema());
            }
        }
    }

}
