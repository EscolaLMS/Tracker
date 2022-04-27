<?php

namespace EscolaLms\Tracker\Trackers;

use EscolaLms\Tracker\Enums\ConfigEnum;
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

    public function isInIgnoreHttpMethod(string $method): bool
    {
        return in_array($method, $this->getIgnoreHttpMethods());
    }

    public function hasSetPrefix(): bool
    {
        return config(ConfigEnum::CONFIG_KEY . '.routes.prefix') !== null;
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
        $method = $request->getMethod();

        return $this->isEnabled()
            && $this->hasPrefix($path)
            && !$this->isInIgnoreUri($path)
            && !$this->isInIgnoreHttpMethod($method);
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
