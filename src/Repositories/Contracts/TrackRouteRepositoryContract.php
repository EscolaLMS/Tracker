<?php

namespace EscolaLms\Tracker\Repositories\Contracts;

use EscolaLms\Core\Repositories\Contracts\BaseRepositoryContract;
use EscolaLms\Tracker\Enums\QueryEnum;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TrackRouteRepositoryContract extends BaseRepositoryContract
{
    public function searchAndPaginateByCriteria(array $criteria, ?int $perPage = QueryEnum::PER_PAGE, string $column = 'created_at', string $order = 'desc'): LengthAwarePaginator;
}
