<?php

namespace EscolaLms\Tracker\Services;

use EscolaLms\Core\Dtos\OrderDto;
use EscolaLms\Tracker\Dto\PaginationDto;
use EscolaLms\Tracker\Dto\TrackRouteSearchDto;
use EscolaLms\Tracker\Repositories\Contracts\TrackRouteRepositoryContract;
use EscolaLms\Tracker\Services\Contracts\TrackRouteServiceContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TrackRouteService implements TrackRouteServiceContract
{
    private TrackRouteRepositoryContract $trackRouteRepository;

    public function __construct(TrackRouteRepositoryContract $trackRouteRepository)
    {
        $this->trackRouteRepository = $trackRouteRepository;
    }

    public function getTrackRoutes(
        TrackRouteSearchDto $searchDto,
        PaginationDto $paginationDto,
        OrderDto $orderDto
    ): LengthAwarePaginator
    {
        return $this->trackRouteRepository->searchAndPaginateByCriteria(
            $searchDto,
            $paginationDto,
            $orderDto
        );
    }
}
