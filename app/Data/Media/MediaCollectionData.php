<?php

namespace App\Data\Media;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Exclude;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class MediaCollectionData extends Data
{
    public function __construct(
        public string $name,

        #[Exclude]
        /** @var string[] */
        public array $mime_types,

        #[Exclude]
        public int $max,

        #[DataCollectionOf(MediaData::class)]
        public DataCollection $items,
    ) {}
}
