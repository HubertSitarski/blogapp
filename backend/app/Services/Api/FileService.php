<?php

namespace App\Services\Api;

use Storage;
use Str;
use App\Models\File;
use App\Repositories\FileRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class FileService
{
    public function __construct(private FileRepositoryInterface $fileRepository)
    {
    }

    public function upload(array $files, Model $model): bool
    {
        $data = new Collection();
        foreach ($files as $uploadedFile) {
            $fileName = Str::random(40) . '.' . $uploadedFile->getClientOriginalExtension();
            $path = $uploadedFile->storeAs('files', $fileName);

            $data->push(
                (new Collection())
                    ->put('model_type', $model::class)
                    ->put('model_id', $model->id)
                    ->put('extension', $uploadedFile->getClientOriginalExtension())
                    ->put('path', $path)
                    ->put('name', $uploadedFile->getClientOriginalName())
            );

        }

        return $this->fileRepository->create($data);
    }

    public function update(File $file, Collection $data): File
    {
        return $this->fileRepository->update($file, $data);
    }

    public function destroy(Collection $files): bool
    {
        foreach ($files as $file) {
            Storage::delete($file->path);
        }

        return $this->fileRepository->destroy($files);
    }
}
