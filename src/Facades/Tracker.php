<?php

namespace EscolaLms\Tracker\Facades;

use EscolaLms\Tracker\Trackers\Contracts\TrackerContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static           bool isEnabled()
 * @method static           bool enable()
 * @method static           bool disable()
 * @method static           string getConnection()
 * @method static           string connection(string $connection)
 * @method static           void ignoreUris(array $uris)
 * @method static           void prefix(?string $prefix)
 *
 * @see \EscolaLms\Tracker\Trackers\Tracker
 */
class Tracker extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return TrackerContract::class;
    }
}
