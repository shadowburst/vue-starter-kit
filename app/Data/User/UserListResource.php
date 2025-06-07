<?php

namespace App\Data\User;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserListResource extends Resource
{
    public function __construct(
        public int $id,
        public string $full_name,
    ) {}
}
