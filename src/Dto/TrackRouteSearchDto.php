<?php

namespace EscolaLms\Tracker\Dto;

use Carbon\Carbon;
use EscolaLms\Core\Dtos\Contracts\DtoContract;
use EscolaLms\Core\Dtos\Contracts\InstantiateFromRequest;
use EscolaLms\Core\Dtos\CriteriaDto;
use EscolaLms\Core\Repositories\Criteria\Primitives\DateCriterion;
use EscolaLms\Core\Repositories\Criteria\Primitives\EqualCriterion;
use EscolaLms\Core\Repositories\Criteria\Primitives\LikeCriterion;
use EscolaLms\Tracker\Enums\QueryEnum;
use EscolaLms\Tracker\Repositories\Criteria\OrderCriterion;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TrackRouteSearchDto extends CriteriaDto implements DtoContract, InstantiateFromRequest
{
    public static function instantiateFromRequest(Request $request): self
    {
        $criteria = new Collection();

        $criteria->push(
            new OrderCriterion(
                $request->get('order_by') ?? QueryEnum::DEFAULT_SORT,
                $request->get('order') ?? QueryEnum::DEFAULT_SORT_DIRECTION
            )
        );

        if ($request->get('path')) {
            $criteria->push(new LikeCriterion('path', $request->get('path')));
        }
        if ($request->get('method')) {
            $criteria->push(new EqualCriterion('method', $request->get('method')));
        }
        if ($request->get('user_id')) {
            $criteria->push(new EqualCriterion('user_id', $request->get('user_id')));
        }
        if ($request->get('date_from')) {
            $criteria->push(
                new DateCriterion(
                    'created_at',
                    new Carbon($request->get('date_from')),
                    '>='
                )
            );
        }
        if ($request->get('date_to')) {
            $criteria->push(
                new DateCriterion(
                    'created_at',
                    new Carbon($request->get('date_to')),
                    '<='
                )
            );
        }

        return new static($criteria);
    }
}
