<?php

namespace App\Services\Api\Repositories;

use App\Models\File;
use App\Repositories\FileRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Services\Api\FileService as BasicFileService;

class FileService
{
    public function __construct(
        private FileRepositoryInterface $fileRepository,
        private BasicFileService $basicFileService
    ) {
    }

    public function findById(int $id): ?File
    {
        return $this->fileRepository->findById($id);
    }

    public function upload(array $files, Model $model): bool
    {
        return $this->fileRepository->create($this->basicFileService->getFilesToUpload($files, $model));
    }

    public function update(File $file, Collection $data): File
    {
        return $this->fileRepository->update($file, $data);
    }

    public function destroy(Collection $files): bool
    {
        $this->basicFileService->deleteFiles($files);

        return $this->fileRepository->destroy($files);
    }
}
