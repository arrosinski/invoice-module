<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(
            static function (Throwable $throwable, Request $request): ?JsonResponse {
                if (!$request->is('api/*')) {
                    return null;
                }

                $statusCode = $throwable instanceof HttpExceptionInterface
                    ? $throwable->getStatusCode()
                    : Response::HTTP_INTERNAL_SERVER_ERROR;

                return response()->json(
                    [
                        'message' => $throwable->getMessage(),
                        'data' => null,
                    ],
                    $statusCode
                );
            }
        );
    }
}
