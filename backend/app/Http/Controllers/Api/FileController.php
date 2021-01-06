<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function __construct(private FileService $fileService)
    {
    }

    public function __invoke($id, Request $request): JsonResponse
    {
        $file = $this->fileService->findById($id);

        //TODO: Obsłużyć więcej typów plików
        if ($file->extension !== 'txt') {
            return response()->json(['message' => 'Cannot generate preview for this file.']);
        }

        return response()->json(['data' => $this->fileService->readFileByLine($file)]);
    }
}
