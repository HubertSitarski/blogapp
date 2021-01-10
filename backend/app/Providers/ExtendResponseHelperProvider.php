<?php

namespace App\Providers;

use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

class ExtendResponseHelperProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('apiResponse', function (
            array $data = [],
            string $code = ResponseCode::HTTP_OK
        ): JsonResponse {
            return response()->json($data, $code);
        });
    }
}
