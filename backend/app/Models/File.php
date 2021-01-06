<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'extension',
        'model_type',
        'model_id'
    ];

    public function model()
    {
        return $this->morphTo();
    }
}
