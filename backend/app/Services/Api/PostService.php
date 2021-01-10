<?php

namespace App\Services\Api;

use App\Models\Post;
use App\Transformers\Api\PostTransformer;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PostService
{
    public function __construct(
        private PostTransformer $postTransformer,
        private FractalService $fractalService
    ) {
    }

    public function updatePublishedAt(Collection $data): Collection
    {
        if ((bool)$data->get('is_published') === true) {
            $data->put('published_at', Carbon::now());
        } else {
            $data->put('published_at', null);
        }

        return $data;
    }

    public function getPostTransformed(Post $post): array
    {
        return $this->fractalService->getTransformedItem(
            $post,
            $this->postTransformer
        );
    }

    public function getPostsTransformed(Collection $data): array
    {
        return $this->fractalService->getTransformedCollection(
            $data,
            $this->postTransformer
        );
    }

    public function changePublicity(Post $post): Post
    {
        if ((!$post->is_published) === true) {
            $post->published_at = Carbon::now();
        }

        return  $post;
    }
}
