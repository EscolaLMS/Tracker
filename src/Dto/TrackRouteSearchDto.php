<?php

namespace EscolaLms\Tracker\Dto;

use EscolaLms\Core\Dtos\Contracts\DtoContract;
use EscolaLms\Core\Dtos\Contracts\InstantiateFromRequest;
use Illuminate\Http\Request;

class TrackRouteSearchDto implements DtoContract, InstantiateFromRequest
{
    private ?string $path;
    private ?string $method;
    private ?string $userId;

    public function __construct(
        ?string $path,
        ?string $method,
        ?string $userId
    )
    {
        $this->path = $path;
        $this->method = $method;
        $this->userId = $userId;
    }

    public function toArray(): array
    {
        return [
            'path' => $this->path,
            'method' => $this->method,
            'userId' => $this->userId,
        ];
    }

    public static function instantiateFromRequest(Request $request): InstantiateFromRequest
    {
        return new static(
            $request->input('path'),
            $request->input('method'),
            $request->input('user_id'),
        );
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }
}
