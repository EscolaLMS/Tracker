<?php

namespace EscolaLms\Tracker\Http\Controllers\Swagger;

use EscolaLms\Tracker\Http\Requests\TrackRouteListRequest;
use Illuminate\Http\JsonResponse;

interface TrackControllerSwagger
{
    public function index(TrackRouteListRequest $request): JsonResponse;
}
