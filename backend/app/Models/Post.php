<?php

namespace App\Models;

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

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'model');
    }

    public function setIsPublishedAttribute($value)
    {
        return (bool)$value;
    }
}
