<?php

namespace App\Traits\Models;

use App\Data\Media\MediaCollectionData;
use App\Data\Media\MediaData;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\LaravelData\DataCollection;
use Spatie\MediaLibrary\InteractsWithMedia as SpatieInteractsWithMedia;

trait InteractsWithMedia
{
    use SpatieInteractsWithMedia {
        bootInteractsWithMedia as protected baseBootInteractsWithMedia;
    }

    public const COLLECTION_ACCEPTS_DOCUMENT = ['text/*', 'application/pdf'];

    public const COLLECTION_ACCEPTS_IMAGE = ['image/jpeg', 'image/png'];

    public const COLLECTION_ACCEPTS_VIDEO = ['video/mp4', 'video/quicktime', 'video/webm'];

    public static function bootInteractsWithMedia(): void
    {
        self::baseBootInteractsWithMedia();
    }

    public function initializeInteractsWithMedia(): void {}

    public function mediaCollections(): Attribute
    {
        return Attribute::get(
            fn (): DataCollection => MediaCollectionData::collect(
                $this->getRegisteredMediaCollections()
                    ->map(
                        fn (MediaCollectionData $collection) => new MediaCollectionData(
                            name       : $collection->name,
                            mime_types : $collection->acceptsMimeTypes,
                            max        : $collection->collectionSizeLimit === false ? 99 : $collection->collectionSizeLimit,
                            items      : MediaData::collect($this->getMedia($collection->name)->toArray(), DataCollection::class),
                        ),
                    )->values(),
                DataCollection::class,
            ),
        );
    }
}
