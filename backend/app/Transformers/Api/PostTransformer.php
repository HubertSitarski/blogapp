<?php

namespace App\Transformers\Api;

use App\Models\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    public function transform(Post $post): array
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
            'is_published' => $post->is_published,
            'published_at' => $post->published_at
        ];
    }
}
