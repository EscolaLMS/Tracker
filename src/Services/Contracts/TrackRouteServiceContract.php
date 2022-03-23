<?php

namespace EscolaLms\Tracker\Services\Contracts;

use EscolaLms\Core\Dtos\OrderDto;
use EscolaLms\Tracker\Dto\PaginationDto;
use EscolaLms\Tracker\Dto\TrackRouteSearchDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TrackRouteServiceContract
{
    public function getTrackRoutes(TrackRouteSearchDto $searchDto, PaginationDto $paginationDto, OrderDto $orderDto): LengthAwarePaginator;
}
