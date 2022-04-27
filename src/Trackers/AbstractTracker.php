<?php

namespace EscolaLms\Tracker\Trackers;

use EscolaLms\Tracker\Enums\ConfigEnum;
use EscolaLms\Tracker\Trackers\Contracts\TrackerContract;
use Illuminate\Support\Facades\Config;

abstract class AbstractTracker implements TrackerContract
{
    public function isEnabled(): bool
    {
        return Config::get(ConfigEnum::CONFIG_KEY . '.enabled', true);
    }

    public function enable(): void
    {
        Config::set(ConfigEnum::CONFIG_KEY . '.enabled', true);
    }

    public function disable(): void
    {
        Config::set(ConfigEnum::CONFIG_KEY . '.enabled', false);
    }

    public function connection(string $connection): void
    {
        Config::set(ConfigEnum::CONFIG_KEY . '.database.connection', $connection);
    }

    public function getConnection(): string
    {
        return Config::get(ConfigEnum::CONFIG_KEY . '.database.connection', env('DB_CONNECTION'));
    }

    public function ignoreUris(array $uris): void
    {
        $value = implode(',', $uris);
        Config::set(ConfigEnum::CONFIG_KEY . '.routes.ignore.uris', $value);
    }

    public function getIgnoreUris(): array
    {
        return explode(',', Config::get(ConfigEnum::CONFIG_KEY . '.routes.ignore.uris'));
    }

    public function ignoreHttpMethods(array $httpMethods): void
    {
        $value = implode(',', $httpMethods);
        Config::set(ConfigEnum::CONFIG_KEY . '.routes.ignore.methods', $value);
    }

    public function getIgnoreHttpMethods(): array
    {
        return explode(',', Config::get(ConfigEnum::CONFIG_KEY . '.routes.ignore.methods'));
    }

    public function prefix(?string $prefix): void
    {
        Config::set(ConfigEnum::CONFIG_KEY . '.routes.prefix', $prefix);
    }

    public function getPrefix(): string
    {
        return Config::get(ConfigEnum::CONFIG_KEY . '.routes.prefix');
    }
}
