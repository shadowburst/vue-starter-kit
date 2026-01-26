<?php

namespace App\Actions\Media;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\QueueableAction\QueueableAction;

class UpdateMedia
{
    use QueueableAction;

    public function __construct(
        //
    ) {}

    public function execute(User $user, HasMedia&Model $model, string $collection, ?string $uuid): bool
    {
        // Reset collection if null given
        if (! $uuid) {
            $model->clearMediaCollection($collection);

            return true;
        }

        /** @var ?\App\Models\Media $media */
        $media = Media::findByUuid($uuid);
        if (! $media) {
            return false;
        }

        if ($media->model()->is($model) && $media->collection_name == $collection) {
            return true;
        }

        if ($media->model()->is($user) && $media->collection_name == User::COLLECTION_TEMP) {
            $media->move($model, $collection);

            return true;
        }

        return false;
    }
}
