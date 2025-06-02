<?php

namespace App\Data\Banner;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class BannerAppResource extends Resource
{
    public function __construct(
        public int $id,
        public string $name,
        public string $message,
        public ?string $action,
    ) {}
}
