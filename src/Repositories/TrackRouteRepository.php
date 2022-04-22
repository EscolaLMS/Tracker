<?php

namespace EscolaLms\Tracker\Repositories;

use EscolaLms\Core\Repositories\BaseRepository;
use EscolaLms\Tracker\Enums\QueryEnum;
use EscolaLms\Tracker\Models\TrackRoute;
use EscolaLms\Tracker\Repositories\Contracts\TrackRouteRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

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

    public function searchAndPaginateByCriteria(
        array $criteria,
        ?int $perPage = QueryEnum::PER_PAGE
    ): LengthAwarePaginator
    {
        $query = $this->model->newQuery();
        $query = $this->applyCriteria($query, $criteria);

        return $query
            ->with(['user'])
            ->paginate($perPage);
    }

    public function create(array $input): Model
    {
        $model = $this->model->fill($input);

        $model->save();

        return $model;
    }
}
