<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (UnauthorizedException $e, $request): JsonResponse {
            return response()->json(['message' => 'Invalid permissions'], Response::HTTP_FORBIDDEN);
        });

        $this->renderable(function (AccessDeniedHttpException $e, $request): JsonResponse {
            return response()->json(['message' => 'Invalid permissions'], Response::HTTP_FORBIDDEN);
        });
    }
}
