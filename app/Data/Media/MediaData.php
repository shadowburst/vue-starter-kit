<?php

namespace App\Data\Media;

use App\Models\Media;
use App\Traits\Data\WithModel;
use Spatie\LaravelData\Attributes\Validation\Exclude;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class MediaData extends Data
{
    /** @use WithModel<Media> */
    use WithModel;

    protected $modelClass = Media::class;

    public function __construct(
        public string $uuid,

        public string $name,

        #[Exclude]
        public string $mime_type,
    ) {}

    public static function attributes(): array
    {
        return [
            'uuid' => __('models.media.fields.uuid'),
            'name' => __('models.media.fields.name'),
        ];
    }

    public static function fromModel(Media $model): self
    {
        $dto = new static(
            uuid      : $model->uuid,
            name      : $model->name,
            mime_type : $model->mime_type,
        );

        return $dto->setModel($model);
    }

    public function findModel()
    {
        return Media::findByUuid($this->uuid);
    }
}
