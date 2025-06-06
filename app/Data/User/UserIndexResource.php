<?php

namespace App\Data\User;

use App\Data\Media\MediaResource;
use Carbon\Carbon;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserIndexResource extends Resource
{
    public function __construct(
        public int $id,
        public string $first_name,
        public string $last_name,
        public string $full_name,
        public string $email,
        public ?string $phone,
        public ?MediaResource $avatar,
        public ?Carbon $deleted_at,
        public bool $can_trash,
        public bool $can_restore,
        public bool $can_delete,
    ) {}
}
