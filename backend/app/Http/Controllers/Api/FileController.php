<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\Repositories\FileService;
use App\Services\Api\FileService as BasicFileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FileController extends Controller
{
    public function __construct(
        private FileService $fileService,
        private BasicFileService $basicFileService
    ) {
    }

    public function __invoke($id, Request $request): JsonResponse
    {
        $file = $this->fileService->findById($id);

        //TODO: Add more file types processing
        if ($file->extension !== 'txt') {
            return Response::apiResponse(['message' => 'Cannot generate preview for this file.']);
        }

        return Response::apiResponse(['data' => $this->basicFileService->readFileByLine($file)]);
    }
}
