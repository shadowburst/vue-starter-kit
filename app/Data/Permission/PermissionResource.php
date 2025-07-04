<?php

namespace App\Data\Permission;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class PermissionResource extends Resource
{
    public function __construct(
        public int $id,
        public string $name,
        public string $display_name,
    ) {}
}
