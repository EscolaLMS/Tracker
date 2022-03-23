<?php

namespace EscolaLms\Tracker\Dto;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use EscolaLms\Core\Dtos\Contracts\DtoContract;
use EscolaLms\Core\Dtos\Contracts\InstantiateFromRequest;
use Illuminate\Http\Request;

class TrackRouteSearchDto implements DtoContract, InstantiateFromRequest
{
    private ?string $path;
    private ?string $method;
    private ?string $userId;
    private ?CarbonInterface $dateFrom;
    private ?CarbonInterface $dateTo;

    public function __construct(
        ?string $path,
        ?string $method,
        ?string $userId,
        ?CarbonInterface $dateFrom,
        ?CarbonInterface $dateTo
    )
    {
        $this->path = $path;
        $this->method = $method;
        $this->userId = $userId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function toArray(): array
    {
        return [
            'path' => $this->path,
            'method' => $this->method,
            'userId' => $this->userId,
            'dateFrom' => $this->dateFrom,
            'dateTo' => $this->dateTo,
        ];
    }

    public static function instantiateFromRequest(Request $request): self
    {
        return new static(
            $request->input('path'),
            $request->input('method'),
            $request->input('user_id'),
            $request->input('date_from') ? new Carbon($request->input('date_from')) : null,
            $request->input('date_to') ? new Carbon($request->input('date_to')) : null,
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

    public function getDateFrom(): ?CarbonInterface
    {
        return $this->dateFrom;
    }

    public function getDateTo(): ?CarbonInterface
    {
        return $this->dateTo;
    }
}
