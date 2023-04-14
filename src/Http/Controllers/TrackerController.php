<?php

namespace EscolaLms\Tracker\Http\Controllers;

use EscolaLms\Core\Dtos\OrderDto;
use EscolaLms\Core\Http\Controllers\EscolaLmsBaseController;
use EscolaLms\Tracker\Dto\PaginationDto;
use EscolaLms\Tracker\Dto\TrackRouteSearchDto;
use EscolaLms\Tracker\Http\Controllers\Swagger\TrackControllerSwagger;
use EscolaLms\Tracker\Http\Requests\TrackRouteListRequest;
use EscolaLms\Tracker\Http\Resources\TrackRouteResource;
use EscolaLms\Tracker\Services\Contracts\TrackRouteServiceContract;
use Illuminate\Http\JsonResponse;

class TrackerController extends EscolaLmsBaseController implements TrackControllerSwagger
{
  private TrackRouteServiceContract $trackRouteService;

  public function __construct(TrackRouteServiceContract $trackRouteService)
  {
    $this->trackRouteService = $trackRouteService;
  }

  public function index(TrackRouteListRequest $request): JsonResponse
  {
    $results = $this->trackRouteService->getTrackRoutes(
      TrackRouteSearchDto::instantiateFromRequest($request),
      PaginationDto::instantiateFromRequest($request),
      OrderDto::instantiateFromRequest($request),
    );

    return $this->sendResponseForResource(
      TrackRouteResource::collection($results),
      __('Track routes retrieved successfully')
    );
  }
}
