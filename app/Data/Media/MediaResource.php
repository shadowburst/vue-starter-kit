<?php

namespace App\Data\Media;

use App\Models\Media;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class MediaResource extends Resource
{
    public function __construct(
        public int $id,
        public string $uuid,
        public string $url,
    ) {}

    public static function fromModel(Media $model): self
    {
        return static::from([
            'id'   => $model->id,
            'uuid' => $model->uuid,
            'url'  => $model->getUrl(),
        ]);
    }
}
