<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Api\FractalService;
use App\Transformers\Api\UserTransformer;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{
    private FractalService $fractalService;

    private UserTransformer $userTransformer;

    public function __construct(FractalService $fractalService, UserTransformer $userTransformer)
    {
        $this->fractalService = $fractalService;
        $this->userTransformer = $userTransformer;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $validatedData['password'] = Hash::make($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json(['user' => $user, 'access_token' => $accessToken]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $loginData = $request->validated();

        if (!auth()->attempt($loginData)) {
            return response()->json(['message' => 'Invalid Credentials']);
        }

        $accessToken = $request->user()->createToken('authToken')->accessToken;

        return response()
            ->json(
                [
                    'user' => $this->fractalService->getTransformedItem(auth()->user(), $this->userTransformer),
                    'access_token' => $accessToken
                ]
            )
            ;
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

}
