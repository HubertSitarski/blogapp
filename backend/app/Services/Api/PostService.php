<?php

namespace App\Services\Api;

use App\Models\Post;
use App\Repositories\FileRepositoryInterface;
use App\Repositories\PostRepositoryInterface;
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

    public function create(Collection $data): Post
    {
        return $this->postRepository->create($data);
    }

    public function update(Post $post, Collection $data): Post
    {
        return $this->postRepository->update($post, $data);
    }

    public function destroy(Post $post): bool
    {
        $this->fileService->destroy($post->files);
        return $this->postRepository->destroy($post);
    }
}
