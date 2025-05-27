<?php

namespace App\Data\User\Admin;

use App\Data\Media\MediaResource;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserAdminIndexResource extends Resource
{
    public function __construct(
        public int $id,
        public string $full_name,
        public string $initials,
        public string $email,
        public ?MediaResource $avatar,
        public bool $is_trashed,
    ) {}
}
