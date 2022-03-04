<?php

namespace EscolaLms\Tracker\Repositories;

use EscolaLms\Core\Dtos\PaginationDto;
use EscolaLms\Core\Repositories\BaseRepository;
use EscolaLms\Core\Repositories\Criteria\Primitives\DateCriterion;
use EscolaLms\Core\Repositories\Criteria\Primitives\EqualCriterion;
use EscolaLms\Core\Repositories\Criteria\Primitives\LikeCriterion;
use EscolaLms\Tracker\Dto\TrackRouteSearchDto;
use EscolaLms\Tracker\Models\TrackRoute;
use EscolaLms\Tracker\Repositories\Contracts\TrackRouteRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TrackRouteRepository extends BaseRepository implements TrackRouteRepositoryContract
{
    public function getFieldsSearchable(): array
    {
        return [
            'user_id',
            'method',
            'path',
            'full_path'
        ];
    }

    public function model(): string
    {
        return TrackRoute::class;
    }

    public function searchAndPaginateByCriteria(TrackRouteSearchDto $criteria, ?PaginationDto $paginationDto = null): LengthAwarePaginator
    {
        $criteria = $this->makeCriteria($criteria);

        $query = $this->model->newQuery();
        $query = $this->applyCriteria($query, $criteria);

        return $query->paginate($paginationDto->getLimit());
    }

    private function makeCriteria(TrackRouteSearchDto $criteria): array
    {
        return [
            $criteria->getPath() ? new LikeCriterion('path', $criteria->getPath()) : null,
            $criteria->getMethod() ? new EqualCriterion('method', $criteria->getMethod()) : null,
            $criteria->getUserId() ? new EqualCriterion('user_id', $criteria->getUserId()) : null,
            $criteria->getDateFrom() ? new DateCriterion('created_at', $criteria->getDateFrom(), '>=') : null,
            $criteria->getDateTo() ? new DateCriterion('created_at', $criteria->getDateTo(), '<=') : null,
        ];
    }
}
