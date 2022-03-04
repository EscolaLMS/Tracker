<?php

namespace EscolaLms\Tracker\Policies;

use EscolaLms\Auth\Models\User;
use EscolaLms\Tracker\Enums\TrackerPermissionEnum;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrackRoutePolicy
{
    use HandlesAuthorization;

    public function list(User $user): bool
    {
        return $user->can(TrackerPermissionEnum::TRACK_ROUTE_LIST);
    }
}
