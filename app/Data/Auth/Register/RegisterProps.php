<?php

namespace App\Data\Auth\Register;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class RegisterProps extends Resource
{
    public function __construct(
        public ?string $status,
    ) {}
}
