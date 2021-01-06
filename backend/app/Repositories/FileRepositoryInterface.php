<?php
namespace App\Repositories;

use App\Models\File;
use Illuminate\Support\Collection;

interface FileRepositoryInterface
{
    public function create(Collection $data): bool;

    public function findById(int $id): ?File;

    public function update(File $file, Collection $data): File;

    public function destroy(Collection $files): bool;
}
