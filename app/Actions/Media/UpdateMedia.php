<?php

namespace App\Actions\Media;

use App\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\QueueableAction\QueueableAction;

class UpdateMedia
{
    use QueueableAction;

    public function __construct(
        //
    ) {}

    public function execute(HasMedia $model, string $collection, ?string $uuid): bool
    {
        // Reset collection if null given
        if (! $uuid) {
            $model->clearMediaCollection($collection);

            return true;
        }

        /** @var ?\App\Models\Media $media */
        $media = rescue(fn () => $model->getMedia('*')->sole('uuid', $uuid));
        if (! $media) {
            return false;
        }

        if ($media->collection_name == $collection) {
            return true;
        }

        if ($media->collection_name == Media::COLLECTION_TEMP) {
            $media->move($model, $collection);

            return true;
        }

        return false;
    }
}
