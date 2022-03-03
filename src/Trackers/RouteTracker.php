<?php

namespace EscolaLms\Tracker\Trackers;

use Illuminate\Support\Str;

class RouteTracker
{
    public static function getIgnoreUris(): array
    {
        return config('escolalms_tracker.rotes.ignore');
    }

    public static function isInIgnoreUri(string $uri): bool
    {
        return in_array($uri, self::getIgnoreUris());
    }

    public static function getPrefix(): string
    {
        return config('escolalms_tracker.rotes.prefix');
    }

    public static function hasSetPrefix(): bool
    {
        return config('escolalms_tracker.rotes.prefix') !== null;
    }

    public static function isPrefix(string $path): bool
    {
        if (!self::hasSetPrefix()) {
            return true;
        }

        return Str::startsWith($path, self::getPrefix());
    }
}
