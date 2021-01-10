<?php

namespace App\Services\Api;

use App\Models\Post;
use App\Repositories\FileRepositoryInterface;
use App\Repositories\PostRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PostService
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private FileService $fileService
    ) {
    }

    public function all(): Collection
    {
        return $this->postRepository->all();
    }

    private function updatePublishedAt(Collection $data): Collection
    {
        if ((bool)$data->get('is_published') === true) {
            $data->put('published_at', Carbon::now());
        } else {
            $data->put('published_at', null);
        }

        return $data;
    }

    public function create(Collection $data): Post
    {
        $data = $this->updatePublishedAt($data);

        return $this->postRepository->create($data);
    }

    public function update(Post $post, Collection $data): Post
    {
        $data = $this->updatePublishedAt($data);

        return $this->postRepository->update($post, $data);
    }

    public function destroy(Post $post): bool
    {
        $this->fileService->destroy($post->files);
        return $this->postRepository->destroy($post);
    }

    public function changePublicity(Post $post): Post
    {
        if ((!$post->is_published) === true) {
            $post->published_at = Carbon::now();
        }

        return $this->postRepository->update($post, collect(['is_published' => !$post->is_published]));
    }
}
