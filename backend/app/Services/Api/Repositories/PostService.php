<?php

namespace App\Services\Api\Repositories;

use App\Models\Post;
use App\Repositories\PostRepositoryInterface;
use Illuminate\Support\Collection;
use App\Services\Api\PostService as BasicPostService;

class PostService
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private FileService $fileService,
        private BasicPostService $basicPostService
    ) {
    }

    public function all(?bool $onlyPublished = false): Collection
    {
        return $this->postRepository->all($onlyPublished);
    }

    public function create(Collection $data): Post
    {
        $data = $this->basicPostService->updatePublishedAt($data);

        return $this->postRepository->create($data);
    }

    public function updateUploadedFiles(Post $post, ?array $files, bool $delete = false)
    {
        if ($files) {
            $delete ? $this->fileService->destroy($post->files) : null;
            $this->fileService->upload($files, $post);
        }
    }

    public function update(Post $post, Collection $data): Post
    {
        $data = $this->basicPostService->updatePublishedAt($data);

        return $this->postRepository->update($post, $data);
    }

    public function destroy(Post $post): bool
    {
        $this->fileService->destroy($post->files);
        return $this->postRepository->destroy($post);
    }
}
