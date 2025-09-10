<?php

namespace App\Data\Banner;

use App\Models\Banner;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class BannerResource extends Resource
{
    public function __construct(
        public int $id,

        public string $name,

        public string $message,

        public ?string $action,

        public bool $is_enabled,
    ) {}

    public static function fromModel(Banner $banner): static
    {
        return static::from([
            'id'         => $banner->id,
            'name'       => $banner->name,
            'message'    => $banner->message,
            'action'     => $banner->action,
            'is_enabled' => $banner->is_enabled,
        ]);
    }
}
