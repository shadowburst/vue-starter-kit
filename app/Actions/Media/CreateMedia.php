<?php

namespace App\Actions\Media;

use App\Data\Media\MediaFormRequest;
use App\Models\Media;
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
    public function execute(MediaFormRequest $data): Media
    {
        $class = Relation::getMorphedModel($data->model_type);

        /** @var \Illuminate\Database\Eloquent\Model&\Spatie\MediaLibrary\HasMedia $model */
        $model = app($class)->query()->findOrFail($data->model_id);

        $media = $model
            ->addMedia($data->file)
            ->toMediaCollection(Media::COLLECTION_TEMP);

        /** @var \Spatie\MediaLibrary\MediaCollections\MediaCollection $collection */
        $collection = method_exists($model, 'getMediaCollection') ? $model->getMediaCollection($data->collection) : null;

        $file = PendingFile::createFromMedia($media);
        $unacceptableForCollection = ! ($collection->acceptsFile)($file, $model);
        $unacceptableForCollection = $unacceptableForCollection || (! empty($collection->acceptsMimeTypes) && ! in_array($file->mimeType, $collection->acceptsMimeTypes));
        if ($unacceptableForCollection) {
            throw FileUnacceptableForCollection::create($file, $collection, $model);
        }

        return $media;
    }
}
