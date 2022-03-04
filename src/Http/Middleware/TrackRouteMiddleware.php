<?php

namespace EscolaLms\Tracker\Http\Middleware;

use Closure;
use EscolaLms\Tracker\Trackers\Contracts\RouteTrackerContract;
use Illuminate\Http\Request;

class TrackRouteMiddleware
{
    private RouteTrackerContract $tracker;

    public function __construct(
        RouteTrackerContract $tracker
    )
    {
        $this->tracker = $tracker;
    }

    public function handle(Request $request, Closure $next)
    {
        if (!$this->tracker->checkRequest($request)) {
            return $next($request);
        }

        $this->tracker->trackRoute($request);

        return $next($request);
    }
}
