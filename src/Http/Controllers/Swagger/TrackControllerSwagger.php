<?php

namespace EscolaLms\Tracker\Http\Controllers\Swagger;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface TrackControllerSwagger
{
    public function index(Request $request): JsonResponse;
}
