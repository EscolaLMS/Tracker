<?php

namespace EscolaLms\Tracker\Trackers\Contracts;

use Illuminate\Http\Request;

interface RouteTrackerContract extends TrackerContract
{
    public function isInIgnoreUri(string $uri): bool;

    public function isInIgnoreHttpMethod(string $method): bool;

    public function hasSetPrefix(): bool;

    public function hasPrefix(string $path): bool;

    public function checkRequest(Request $request): bool;

    public function trackRoute(Request $request): void;
}
