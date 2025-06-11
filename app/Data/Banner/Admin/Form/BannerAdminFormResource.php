<?php

namespace App\Data\Banner\Admin\Form;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class BannerAdminFormResource extends Resource
{
    public function __construct(
        public int $id,
        public string $name,
        public string $message,
        public ?string $action,
        public bool $is_enabled,
    ) {}
}
