<?php

namespace App\Data\Team;

use Carbon\Carbon;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TeamIndexResource extends Resource
{
    public function __construct(
        public int $id,
        public string $name,
        public ?Carbon $deleted_at,
        public bool $can_trash,
        public bool $can_restore,
        public bool $can_delete,
    ) {}
}
