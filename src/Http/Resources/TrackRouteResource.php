<?php

namespace EscolaLms\Tracker\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrackRouteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'path' => $this->path,
            'full_path' => $this->full_path,
            'method' => $this->method,
            'extra' => $this->extra
        ];
    }
}
