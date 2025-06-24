<?php

namespace App\Data\User;

use App\Data\Media\MediaResource;
use App\Data\Team\TeamListResource;
use Spatie\LaravelData\Attributes\AutoWhenLoadedLazy;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserResource extends Resource
{
    public function __construct(
        public int $id,
        public int $owner_id,
        public ?int $team_id,
        public string $first_name,
        public string $last_name,
        public string $full_name,
        public string $email,
        public ?string $phone,

        public bool $is_admin,
        public bool $is_owner,
        public bool $is_member,

        #[AutoWhenLoadedLazy]
        public Lazy|Optional|MediaResource $avatar,

        #[AutoWhenLoadedLazy]
        #[DataCollectionOf(TeamListResource::class)]
        public Lazy|DataCollection $teams,
    ) {}
}
