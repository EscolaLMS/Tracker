<?php

namespace EscolaLms\Tracker\Http\Controllers;

use EscolaLms\Core\Dtos\PaginationDto;
use EscolaLms\Core\Http\Controllers\EscolaLmsBaseController;
use EscolaLms\Tracker\Dto\TrackRouteSearchDto;
use EscolaLms\Tracker\Http\Controllers\Swagger\TrackControllerSwagger;
use EscolaLms\Tracker\Services\Contracts\TrackRouteServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrackerController extends EscolaLmsBaseController implements TrackControllerSwagger
{
    private TrackRouteServiceContract $trackRouteService;

    public function __construct(TrackRouteServiceContract $trackRouteService)
    {
        $this->trackRouteService = $trackRouteService;
    }

    public function index(Request $request): JsonResponse
    {
        $results = $this->trackRouteService->getTrackRoutes(
            PaginationDto::instantiateFromRequest($request),
            TrackRouteSearchDto::instantiateFromRequest($request)
        );

        return new JsonResponse($results);
    }
}
