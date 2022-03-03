<?php

namespace EscolaLms\Tracker\Trackers;

abstract class AbstractTracker
{
    public static function enabled(): bool
    {
        return config('escolalms_tracker.enabled');
    }
}
