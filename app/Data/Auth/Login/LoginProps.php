<?php

namespace App\Data\Auth\Login;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class LoginProps extends Resource
{
    public function __construct(
        public bool $canResetPassword,

        public ?string $status,
    ) {}
}
