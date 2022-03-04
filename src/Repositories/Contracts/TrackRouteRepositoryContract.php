<?php

namespace EscolaLms\Tracker\Repositories\Contracts;

use EscolaLms\Core\Dtos\PaginationDto;
use EscolaLms\Core\Repositories\Contracts\BaseRepositoryContract;
use EscolaLms\Tracker\Dto\TrackRouteSearchDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TrackRouteRepositoryContract extends BaseRepositoryContract
{
    public function searchAndPaginateByCriteria(TrackRouteSearchDto $criteria, ?PaginationDto $paginationDto = null): LengthAwarePaginator;
}
