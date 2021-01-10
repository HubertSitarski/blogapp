<?php

namespace App\Services\Api;

use Storage;
use Generator;
use Illuminate\Database\Eloquent\Model;
use Str;
use App\Models\File;
use Illuminate\Support\Collection;

class FileService
{
    protected function getFilePreviewGenerator(File $file): Generator
    {
        $fileStream = fopen((storage_path('app/' . $file->path)), "r");

        while (!feof($fileStream)) {
            yield fgets($fileStream);
        }

        fclose($fileStream);
    }

    public function readFileByLine(File $file): Collection
    {
        $counter = 1;
        $collection = new Collection();

        foreach ($this->getFilePreviewGenerator($file) as $line) {
            $collection->put('line_' . $counter, Str::fixEncoding($line));
            $counter++;
        }

        return $collection;
    }

    public function getFilesToUpload(array $files, Model $model): Collection
    {
        $data = new Collection();
        foreach ($files as $uploadedFile) {
            $fileName = Str::random(40) . '.' . $uploadedFile->getClientOriginalExtension();
            $path = $uploadedFile->storeAs('public/files', $fileName);

            $data->push(collect([
                'model_type' => $model::class,
                'model_id' => $model->id,
                'extension' => $uploadedFile->getClientOriginalExtension(),
                'path' => $path,
                'name' => $uploadedFile->getClientOriginalName()
            ]));
        }

        return $data;
    }

    public function deleteFiles(Collection $files): void
    {
        foreach ($files as $file) {
            Storage::delete($file->path);
        }
    }
}
