<?php

namespace App\Data\Team;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TeamFormResource extends Resource
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
}
