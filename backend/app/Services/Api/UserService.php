<?php

namespace App\Services\Api;

use App\Models\User;
use App\Transformers\Api\UserTransformer;
use Illuminate\Support\Collection;
use League\Fractal\Serializer\DataArraySerializer;

class UserService
{
    public function __construct(
        private FractalService $fractalService,
        private UserTransformer $userTransformer
    ) {
    }

    public function getUserTransformed(
        User $user,
        ?array $includes = [],
        ?string $serializer = DataArraySerializer::class
    ): array {
        return $this->fractalService->getTransformedItem(
            $user,
            $this->userTransformer,
            $includes,
            $serializer
        );
    }

    public function getUsersTransformed(
        Collection $data,
        ?array $includes = [],
        ?string $serializer = DataArraySerializer::class
    ): array {
        return $this->fractalService->getTransformedCollection(
            $data,
            $this->userTransformer,
            $includes,
            $serializer
        );
    }

    public function hashPassword(string $password): string
    {
        return \Hash::make($password);
    }
}
