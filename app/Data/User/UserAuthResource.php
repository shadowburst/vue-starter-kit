<?php

namespace App\Data\User;

use App\Data\Media\MediaResource;
use App\Data\Team\TeamListResource;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserAuthResource extends Resource
{
    public function __construct(
        public int $id,
        public ?int $team_id,
        public string $first_name,
        public string $last_name,
        public string $full_name,
        public ?string $phone,
        public string $email,
        public ?MediaResource $avatar,
        public bool $is_admin,
        public bool $is_owner,
        public bool $is_member,

        #[DataCollectionOf(TeamListResource::class)]
        public DataCollection $teams,
    ) {}
}
