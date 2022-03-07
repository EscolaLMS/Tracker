<?php

namespace EscolaLms\Tracker\Http\Controllers\Swagger;

use EscolaLms\Tracker\Http\Requests\TrackRouteListRequest;
use Illuminate\Http\JsonResponse;

interface TrackControllerSwagger
{
    /**
     * @OA\Get(
     *     path="/api/admin/tracks/routes",
     *     summary="Lists available tracked routes",
     *     tags={"Tracker"},
     *     security={
     *         {"passport": {}},
     *     },
     *     @OA\Parameter(
     *         description="Id of User",
     *         in="query",
     *         name="user_id",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Route path",
     *         in="query",
     *         name="path",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Http method",
     *         in="query",
     *         name="method",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Date from",
     *         in="query",
     *         name="date_from",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Date to",
     *         in="query",
     *         name="date_to",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of available",
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Endpoint requires authentication",
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="User doesn't have required access rights",
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Server-side error",
     *      ),
     * )
     *
     * @param TrackRouteListRequest $request
     * @return JsonResponse
     */
    public function index(TrackRouteListRequest $request): JsonResponse;
}
