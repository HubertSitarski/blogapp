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

        return $this->userRepository->create($data);
    }
}
