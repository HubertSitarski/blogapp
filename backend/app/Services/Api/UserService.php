<?php

namespace App\Services\Api;

use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\Collection;

class UserService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function register(Collection $data): User
    {
        $data->put('password', \Hash::make($data->get('password')));

        return $this->userRepository->create($data);
    }
}
