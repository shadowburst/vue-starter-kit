<?php

namespace App\Data\Role;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class RoleListResource extends Resource
{
    public function __construct(
        public int $id,
        public string $name,
        public string $display_name,
    ) {}
}
