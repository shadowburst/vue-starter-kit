<?php

namespace App\Data\Auth\VerifyEmail;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class VerifyEmailProps extends Resource
{
    public function __construct(
        public ?string $status,
    ) {}
}
