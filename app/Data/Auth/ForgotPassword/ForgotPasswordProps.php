<?php

namespace App\Data\Auth\ForgotPassword;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ForgotPasswordProps extends Resource
{
    public function __construct(
        public ?string $status,
    ) {}
}
