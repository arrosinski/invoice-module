<?php

declare(strict_types=1);

namespace App\Infrastructure;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function jsonResponse(
        ?string $message,
        ?array $data,
        int $status = Response::HTTP_OK,
        array $headers = []
    ): JsonResponse {
        return response()->json(
            [
                'message' => $message,
                'data' => $data,
            ],
            $status,
            $headers
        );
    }
}
