<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\RegisterRequest;
use App\Jobs\SendRegisteredNotificationJob;
use App\Notifications\UserRegisteredNotification;
use App\Services\Api\FractalService;
use App\Services\Api\UserService;
use App\Transformers\Api\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use League\Fractal\Serializer\ArraySerializer;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(
        private FractalService $fractalService,
        private UserTransformer $userTransformer,
        private UserService $userService
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userService->register(collect($request->validated()));
        SendRegisteredNotificationJob::dispatch($user);
        return response()
            ->json($this->fractalService->getTransformedItem($user, $this->userTransformer), Response::HTTP_CREATED)
            ;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (!auth()->attempt($request->validated())) {
            return response()->json(['message' => 'Invalid Credentials'], Response::HTTP_UNAUTHORIZED);
        }

        $user = $this
            ->fractalService
            ->getTransformedItem(auth()->user(), $this->userTransformer, [], ArraySerializer::class)
        ;

        return response()
            ->json(['data' => $user, 'token' => $request->user()->createToken('authToken')->accessToken]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
