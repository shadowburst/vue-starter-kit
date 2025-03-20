<?php

namespace App\Data\Auth\ResetPassword;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ResetPasswordProps extends Resource
{
    public function __construct(
        public string $token,
        public string $email,
        public ?string $status,
    ) {}
}
