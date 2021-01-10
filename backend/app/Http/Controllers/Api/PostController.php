<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use App\Services\Api\FileService;
use App\Services\Api\FractalService;
use App\Services\Api\Repositories\PostService;
use App\Services\Api\PostService as BasicPostService;
use App\Transformers\Api\PostTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class PostController extends Controller
{
    public function __construct(
        private PostService $postService,
        private FractalService $fractalService,
        private PostTransformer $postTransformer,
        private FileService $fileService,
        private BasicPostService $basicPostService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $posts = $this
            ->basicPostService
            ->getPostsTransformed($this->postService->all($request->get('only_published')));

        return Response::apiResponse($posts);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $post = $this->postService->create(collect($request->all()));

        $files = $request->file('files');

        $this->postService->updateUploadedFiles($post, $files);

        return Response::apiResponse($this->basicPostService->getPostTransformed($post), ResponseCode::HTTP_CREATED);
    }

    public function show(Post $post): JsonResponse
    {
        return Response::apiResponse($this->basicPostService->getPostTransformed($post));
    }

    public function update(UpdateRequest $request, Post $post): JsonResponse
    {
        $files = $request->file('files');

        $this->postService->updateUploadedFiles($post, $files, true);

        $post = $this->postService->update($post, collect($request->all()));

        return Response::apiResponse($this->basicPostService->getPostTransformed($post));
    }

    public function destroy(Post $post): JsonResponse
    {
        $this->postService->destroy($post);
        return Response::apiResponse([], ResponseCode::HTTP_NO_CONTENT);
    }
}
