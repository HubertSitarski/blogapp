<?php

namespace App\Http\Controllers\Api;

use Gate;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Api\FractalService;
use App\Services\Api\Repositories\UserService;
use App\Services\Api\UserService as BasicUserSerivce;
use App\Transformers\Api\UserTransformer;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    public function __construct(
        private FractalService $fractalService,
        private UserTransformer $userTransformer,
        private UserService $userService,
        private BasicUserSerivce $basicUserService
    ) {
    }

    public function show(User $user): JsonResponse
    {
        Gate::authorize('manage-profile', $user);
        return Response::apiResponse($this->basicUserService->getUserTransformed($user));
    }

    public function update(UpdateRequest $request, User $user): JsonResponse
    {
        Gate::authorize('manage-profile', $user);
        return Response::apiResponse(
            $this
            ->basicUserService
            ->getUserTransformed($this->userService->update($user, collect($request->validated())))
        );
    }
}
