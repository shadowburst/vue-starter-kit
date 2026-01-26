<?php

namespace App\Actions\Media;

use App\Data\Media\MediaFormRequest;
use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileUnacceptableForCollection;
use Spatie\MediaLibrary\MediaCollections\File as PendingFile;
use Spatie\QueueableAction\QueueableAction;

class CreateMedia
{
    use QueueableAction;

    public function __construct(
        //
    ) {}

    /**
     * @throws FileUnacceptableForCollection
     */
    public function execute(MediaFormRequest $data, User $user): Media
    {
        /** @var \Illuminate\Database\Eloquent\Model&\Spatie\MediaLibrary\HasMedia&\App\Traits\Models\InteractsWithMedia $model */
        $model = app(Relation::getMorphedModel($data->model_type));

        $media = $user
            ->addMedia($data->file);

        $media = $media->toMediaCollection(User::COLLECTION_TEMP);

        /** @var \Spatie\MediaLibrary\MediaCollections\MediaCollection $collection */
        $collection = $model->getMediaCollection($data->collection_name);

        $file = PendingFile::createFromMedia($media);
        $unacceptableForCollection = ! ($collection->acceptsFile)($file, $model);
        $unacceptableForCollection = $unacceptableForCollection || (! empty($collection->acceptsMimeTypes) && ! in_array($file->mimeType, $collection->acceptsMimeTypes));
        if ($unacceptableForCollection) {
            throw FileUnacceptableForCollection::create($file, $collection, $model);
        }

        return $media;
    }
}
