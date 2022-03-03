<?php

namespace EscolaLms\Tracker\Services\Contracts;

use EscolaLms\Core\Dtos\PaginationDto;
use EscolaLms\Tracker\Dto\TrackRouteSearchDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TrackRouteServiceContract
{
    public function getTrackRoutes(PaginationDto $paginationDto, TrackRouteSearchDto $searchDto): LengthAwarePaginator;

}
