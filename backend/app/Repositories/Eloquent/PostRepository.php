<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\PostRepositoryInterface;
use Illuminate\Support\Collection;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function __construct(
        Post $model
    ) {
        parent::__construct($model);
    }

    public function all(?bool $onlyPublished = false): Collection
    {
        return $onlyPublished === true ?  $this->model->published()->get() : $this->model->all();
    }

    public function create(Collection $data): Post
    {
        return $this->model->create($data->toArray());
    }

    public function update(Post $post, Collection $data): Post
    {
        return tap($post)->update($data->toArray());
    }

    public function destroy(Post $post): bool
    {
        return $post->delete();
    }
}
