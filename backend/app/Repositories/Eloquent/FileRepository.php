<?php

namespace App\Repositories\Eloquent;

use App\Models\File;
use App\Repositories\FileRepositoryInterface;
use Illuminate\Support\Collection;

class FileRepository extends BaseRepository implements FileRepositoryInterface
{
    public function __construct(
        File $model
    ) {
        parent::__construct($model);
    }

    public function create(Collection $data): bool
    {
        return $this->model->insert($data->toArray());
    }

    public function findById(int $id): ?File
    {
        return $this->model->find($id);
    }


    public function update(File $file, Collection $data): File
    {
        $file->update($data->toArray());
        return $file;
    }

    public function destroy(Collection $files): bool
    {
        return $this->model->destroy($files->pluck('id'));
    }
}
