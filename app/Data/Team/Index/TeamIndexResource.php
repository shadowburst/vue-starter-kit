<?php

namespace App\Data\Team\Index;

use App\Data\Media\MediaResource;
use Carbon\Carbon;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TeamIndexResource extends Resource
{
    public function __construct(
        public int $id,
        public int $creator_id,
        public ?MediaResource $logo,
        public string $name,
        public bool $can_view,
        public bool $can_update,
        public bool $can_trash,
        public bool $can_restore,
        public bool $can_delete,
        public ?Carbon $deleted_at,
    ) {}
}
