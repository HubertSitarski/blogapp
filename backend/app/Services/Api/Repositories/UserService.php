<?php

namespace App\Services\Api\Repositories;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;
use App\Services\Api\UserService as BasicUserService;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private BasicUserService $basicUserService
    ) {
    }

    public function register(Collection $data): User
    {
        $data->put('password', $this->basicUserService->hashPassword($data->get('password')));

        $user = $this->userRepository->create($data);

        $user->assignRole(['User']);
        return $user;
    }

    public function all(): Collection
    {
        return $this->userRepository->all();
    }

    public function update(User $user, Collection $data): User
    {
        return $this->userRepository->update($user, $data);
    }
}
