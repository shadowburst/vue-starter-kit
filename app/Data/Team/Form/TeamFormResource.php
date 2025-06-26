<?php

namespace App\Data\Team\Form;

use App\Data\Media\MediaResource;
use App\Data\Team\TeamSettingsData;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TeamFormResource extends Resource
{
    public function __construct(
        public int $id,
        public int $creator_id,
        public ?MediaResource $logo,
        public string $name,
        public ?TeamSettingsData $settings,
        public bool $can_view,
        public bool $can_update,
        public bool $can_trash,
        public bool $can_restore,
        public bool $can_delete,
    ) {}
}
