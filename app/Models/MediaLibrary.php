<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MediaLibrary extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $timestamps = false;

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('uploads')
            ->useDisk('public')
            ->acceptsFile(fn ($file) => str_starts_with($file->mimeType, 'image/'));
    }
}
