<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function all(): Collection;

    public function create(Collection $data): User;

    public function update(User $user, Collection $data): User;
}
