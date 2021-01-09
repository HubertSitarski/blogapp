<?php

namespace App\Services\Api;

use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserService
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function register(Collection $data): User
    {
        $data->put('password', \Hash::make($data->get('password')));

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
