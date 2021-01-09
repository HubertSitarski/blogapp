<?php

namespace App\Http\Controllers\Api;

use Gate;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Api\FractalService;
use App\Services\Api\UserService;
use App\Transformers\Api\UserTransformer;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\User\UpdateRequest;

class ProfileController extends Controller
{
    public function __construct(
        private FractalService $fractalService,
        private UserTransformer $userTransformer,
        private UserService $userService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()
            ->json(
                $this->fractalService->getTransformedCollection($this->userService->all(), $this->userTransformer)
            );
    }

    public function show(User $user): JsonResponse
    {
        Gate::authorize('manage-profile', $user);
        return response()->json($this->fractalService->getTransformedItem($user, $this->userTransformer));
    }

    public function update(UpdateRequest $request, User $user): JsonResponse
    {
        Gate::authorize('manage-profile', $user);
        return response()
            ->json(
                $this
                    ->fractalService
                    ->getTransformedItem(
                        $this->userService->update($user, collect($request->validated())),
                        $this->userTransformer
                    )
            );
    }
}
