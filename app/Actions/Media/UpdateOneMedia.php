<?php

namespace App\Actions\Media;

use App\Models\Media;
use App\Traits\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\QueueableAction\QueueableAction;

class UpdateOneMedia
{
    use QueueableAction;

    /**
     * Create a new action instance.
     */
    public function __construct(
        //
    ) {}

    /**
     * Execute the action.
     *
     * @
     */
    public function execute(HasMedia $model, string $collection, ?string $uuid): bool
    {
        // if (! in_array(InteractsWithMedia::class, class_uses_recursive($model::class))) {
        //     throw new \Exception('Invalid class');
        // }

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
