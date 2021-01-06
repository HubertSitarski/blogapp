<?php

namespace App\Transformers\Api;

use App\Models\File;
use League\Fractal\TransformerAbstract;

class FileTransformer extends TransformerAbstract
{
    public function transform(File $file): array
    {
        return [
            'id' => $file->id,
            'name' => $file->name,
            'path' => $file->path,
            'extension' => $file->extension
        ];
    }
}
