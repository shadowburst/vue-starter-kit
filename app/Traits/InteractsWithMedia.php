<?php

namespace App\Traits;

use App\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia as SpatieInteractsWithMedia;

trait InteractsWithMedia
{
    use SpatieInteractsWithMedia {
        bootInteractsWithMedia as protected baseBootInteractsWithMedia;
    }

    /**
     * Boot the InteractsWithMedia trait for a class.
     */
    public static function bootInteractsWithMedia(): void
    {
        self::baseBootInteractsWithMedia();
    }

    /**
     * Initialize the InteractsWithMediatrait for an instance.
     */
    public function initializeInteractsWithMedia(): void
    {
        $this->addMediaCollection(Media::COLLECTION_TEMP)
            ->onlyKeepLatest(25);
    }
}
