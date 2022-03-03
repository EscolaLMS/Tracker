<?php

namespace EscolaLms\Tracker\Http\Middleware;

use Closure;
use EscolaLms\Tracker\Repositories\Contracts\TrackRouteRepositoryContract;
use EscolaLms\Tracker\Trackers\RouteTracker;
use Illuminate\Http\Request;

class TrackRouteMiddleware
{
    private TrackRouteRepositoryContract $repository;

    public function __construct(
        TrackRouteRepositoryContract $repository
    )
    {
        $this->repository = $repository;
    }

    public function handle(Request $request, Closure $next)
    {
        $path = $request->getPathInfo();
        if (!RouteTracker::isPrefix($path) || RouteTracker::isInIgnoreUri($path)) {
            return $next($request);
        }

        $this->repository->create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'path' => $path,
            'full_path' => $request->getRequestUri(),
            'method' => $request->getMethod(),
        ]);

        return $next($request);
    }
}
