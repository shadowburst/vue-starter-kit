<?php

namespace App\Data\User;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserEditProps extends Resource
{
    public function __construct(
        public UserFormResource $user,
    ) {}
}
