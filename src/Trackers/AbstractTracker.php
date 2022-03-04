<?php

namespace EscolaLms\Tracker\Trackers;

use EscolaLms\Tracker\Trackers\Contracts\TrackerContract;
use Illuminate\Support\Facades\Config;

abstract class AbstractTracker implements TrackerContract
{
    public function isEnabled(): bool
    {
        return Config::get('escolalms_tracker.enabled', true);
    }

    public function enable(): void
    {
        Config::set('escolalms_tracker.enabled', true);
    }

    public function disable(): void
    {
        Config::set('escolalms_tracker.enabled', false);
    }

    public function connection(string $connection): void
    {
        Config::set('escolalms_tracker.database.connection', $connection);
    }

    public function getConnection(): string
    {
        // return Config::get('escolalms_tracker.database.connection', env('DB_CONNECTION'));
        return env('DB_CONNECTION');
    }

    public function ignoreUris(array $uris): void
    {
        Config::set('escolalms_tracker.routes.ignore', $uris);
    }

    public function getIgnoreUris(): array
    {
        return Config::get('escolalms_tracker.routes.ignore');
    }

    public function prefix(?string $prefix): void
    {
        Config::set('escolalms_tracker.routes.prefix', $prefix);
    }

    public function getPrefix(): string
    {
        return Config::get('escolalms_tracker.routes.prefix');
    }
}
