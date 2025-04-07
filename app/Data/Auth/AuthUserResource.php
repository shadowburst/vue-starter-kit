<?php

namespace App\Data\Auth;

use App\Data\Media\MediaResource;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AuthUserResource extends Resource
{
    public function __construct(
        public int $id,
        public string $first_name,
        public string $last_name,
        public string $full_name,
        public string $initials,
        public string $email,
        public ?MediaResource $avatar,
    ) {}
}
