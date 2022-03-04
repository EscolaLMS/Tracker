<?php

namespace EscolaLms\Tracker\Trackers;

use EscolaLms\Tracker\Repositories\Contracts\TrackRouteRepositoryContract;
use EscolaLms\Tracker\Trackers\Contracts\RouteTrackerContract;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RouteTracker extends Tracker implements RouteTrackerContract
{
    private TrackRouteRepositoryContract $repository;

    public function __construct(
        TrackRouteRepositoryContract $repository
    )
    {
        $this->repository = $repository;
    }

    public function isInIgnoreUri(string $uri): bool
    {
        return in_array($uri, $this->getIgnoreUris());
    }

    public function hasSetPrefix(): bool
    {
        return config('escolalms_tracker.routes.prefix') !== null;
    }

    public function hasPrefix(string $path): bool
    {
        if (!$this->hasSetPrefix()) {
            return true;
        }

        return Str::startsWith($path, $this->getPrefix());
    }

    public function checkRequest(Request $request): bool
    {
        $path = $request->getPathInfo();
        return $this->isEnabled() && $this->hasPrefix($path) && !$this->isInIgnoreUri($path);
    }

    public function trackRoute(Request $request): void
    {
        $this->repository->create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'path' => $request->getPathInfo(),
            'full_path' => $request->getRequestUri(),
            'method' => $request->getMethod(),
        ]);
    }
}
