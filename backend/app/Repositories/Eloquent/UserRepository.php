<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(
        User $model
    ) {
        parent::__construct($model);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function create(Collection $data): User
    {
        return $this->model->create($data->toArray());
    }
    public function update(User $user, Collection $data): User
    {
        return tap($user)->update($data->toArray());
    }
}
