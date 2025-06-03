<?php

namespace App\Data\User\Admin;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserAdminEditProps extends Resource
{
    public function __construct(
        public UserAdminFormResource $user,
    ) {}
}
