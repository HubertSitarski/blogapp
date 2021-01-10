<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'is_published',
        'published_at'
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'model');
    }

    public function updatePublishedAt()
    {
        if ((bool)$this->is_published === true) {
            $this->published_at = Carbon::now();
        } else {
            $this->published_at = null;
        }
    }
}
