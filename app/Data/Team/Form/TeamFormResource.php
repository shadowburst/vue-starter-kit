<?php

namespace App\Data\Team\Form;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TeamFormResource extends Resource
{
    public function __construct(
        public int $id,
        public int $creator_id,
        public string $name,
        public bool $can_view,
        public bool $can_update,
        public bool $can_trash,
        public bool $can_restore,
        public bool $can_delete,
    ) {}
}
