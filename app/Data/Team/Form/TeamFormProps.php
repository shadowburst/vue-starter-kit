<?php

namespace App\Data\Team\Form;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TeamFormProps extends Resource
{
    public function __construct(
        public ?TeamFormResource $team,
    ) {}
}
