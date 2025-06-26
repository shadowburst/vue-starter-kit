<?php

namespace App\Data\Team;

use App\Data\Media\MediaResource;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TeamResource extends Resource
{
    public function __construct(
        public int $id,
        public string $name,
        public ?MediaResource $logo,
        public ?TeamSettingsData $settings,
    ) {}
}
