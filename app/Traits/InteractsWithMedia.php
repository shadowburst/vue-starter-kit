<?php

namespace App\Traits;

use App\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia as SpatieInteractsWithMedia;

trait InteractsWithMedia
{
    use SpatieInteractsWithMedia {
        bootInteractsWithMedia as protected baseBootInteractsWithMedia;
    }

    public static function bootInteractsWithMedia(): void
    {
        self::baseBootInteractsWithMedia();
    }

    public function initializeInteractsWithMedia(): void
    {
        $this->addMediaCollection(Media::COLLECTION_TEMP);
    }
}
