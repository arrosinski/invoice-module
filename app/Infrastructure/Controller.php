<?php

declare(strict_types=1);

namespace App\Infrastructure;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected function resourceResponse(JsonResource $jsonResource, int $responseCode = Response::HTTP_OK): JsonResource
    {
        return $jsonResource->additional([
            'success' => true,
        ]);
    }

    protected function errorResponse(
        string $message,
        int $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        array $data = []
    ): JsonResponse {
        $responseData = [
            'success' => false,
            'message' => $message,
        ];

        if ($data) {
            $responseData['data'] = $data;
        }

        return new JsonResponse($responseData, $responseCode);
    }

    protected function notFoundResponse(): JsonResponse
    {
        return new JsonResponse([
            'success' => false,
            'message' => 'Requested resource not found!',
        ], Response::HTTP_NOT_FOUND);
    }
}
