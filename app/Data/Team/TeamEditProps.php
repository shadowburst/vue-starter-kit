<?php

namespace App\Data\Team;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TeamEditProps extends Resource
{
    public function __construct(
        public TeamFormResource $team,
    ) {}
}
