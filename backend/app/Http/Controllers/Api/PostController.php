<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use App\Services\Api\FileService;
use App\Services\Api\FractalService;
use App\Services\Api\PostService;
use App\Transformers\Api\PostTransformer;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function __construct(
        private PostService $postService,
        private FractalService $fractalService,
        private PostTransformer $postTransformer,
        private FileService $fileService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()
            ->json(
                $this->fractalService->getTransformedCollection($this->postService->all(), $this->postTransformer)
            );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $post = $this->postService->create(collect($request->all()));

        $files = $request->file('files');

        if ($files && is_array($files)) {
            $this->fileService->upload($files, $post);
        }

        return response()
            ->json(
                $this
                    ->fractalService
                    ->getTransformedItem(
                        $post,
                        $this->postTransformer
                    ),
                Response::HTTP_CREATED
            );
    }

    public function show(Post $post): JsonResponse
    {
        return response()
            ->json($this->fractalService->getTransformedItem($post, $this->postTransformer))
            ;
    }

    public function update(UpdateRequest $request, Post $post): JsonResponse
    {
        $files = $request->file('files');

        if ($files && is_array($files)) {
            $this->fileService->destroy($post->files);
            $this->fileService->upload($files, $post);
        }

        return response()
            ->json(
                $this
                    ->fractalService
                    ->getTransformedItem(
                        $this->postService->update($post, collect($request->validated())),
                        $this->postTransformer
                    )
            );
    }

    public function destroy(Post $post): JsonResponse
    {
        return response()->json($this->postService->destroy($post), Response::HTTP_NO_CONTENT);
    }
}
