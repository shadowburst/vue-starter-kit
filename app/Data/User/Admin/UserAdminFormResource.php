<?php

namespace App\Data\User\Admin;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserAdminFormResource extends Resource
{
    public function __construct(
        public int $id,
        public string $first_name,
        public string $last_name,
        public string $email,
        public ?string $phone,
    ) {}
}
