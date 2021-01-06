<?php
namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Collection;

interface PostRepositoryInterface
{
    public function all(): Collection;

    public function create(Collection $data): Post;

    public function update(Post $post, Collection $data): Post;

    public function destroy(Post $post): bool;
}
