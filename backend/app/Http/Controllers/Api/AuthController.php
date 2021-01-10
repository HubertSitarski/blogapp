<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\RegisterRequest;
use App\Jobs\SendRegisteredNotificationJob;
use App\Services\Api\FractalService;
use App\Services\Api\Repositories\UserService;
use App\Services\Api\UserService as BasicUserService;
use App\Transformers\Api\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Response;
use League\Fractal\Serializer\ArraySerializer;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class AuthController extends Controller
{
    public function __construct(
        private FractalService $fractalService,
        private UserTransformer $userTransformer,
        private UserService $userService,
        private BasicUserService $basicUserService
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userService->register(collect($request->validated()));
        SendRegisteredNotificationJob::dispatch($user);

        return Response::apiResponse($this->basicUserService->getUserTransformed($user), ResponseCode::HTTP_CREATED);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (!auth()->attempt($request->validated())) {
            return response()->json(['message' => 'Invalid Credentials'], Response::HTTP_UNAUTHORIZED);
        }

        $user = $this->basicUserService->getUserTransformed(auth()->user(), [], ArraySerializer::class);

        return Response::apiResponse([
            'data' => $user,
            'token' => $request->user()->createToken('authToken')->accessToken
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return Response::apiResponse(['message' => 'Successfully logged out']);
    }
}
