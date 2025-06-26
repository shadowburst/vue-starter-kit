<?php

namespace App\Data\Media;

use App\Models\Media;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\RecordTypeScriptType;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class MediaResource extends Resource
{
    public function __construct(
        public int $id,
        public string $uuid,
        public string $url,

        #[RecordTypeScriptType('string', 'any')]
        public ?array $custom_properties,
    ) {}

    public static function fromModel(Media $model): self
    {
        return static::from([
            'id'                => $model->id,
            'uuid'              => $model->uuid,
            'url'               => $model->getUrl(),
            'custom_properties' => empty($model->custom_properties) ? null : $model->custom_properties,
        ]);
    }
}
