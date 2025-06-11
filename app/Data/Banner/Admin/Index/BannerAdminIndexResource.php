<?php

namespace App\Data\Banner\Admin\Index;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class BannerAdminIndexResource extends Resource
{
    public function __construct(
        public int $id,
        public string $name,
        public bool $is_enabled,
    ) {}
}
