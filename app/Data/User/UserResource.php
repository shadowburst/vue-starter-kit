<?php

namespace App\Data\User;

use App\Data\Media\MediaResource;
use App\Data\Team\TeamListResource;
use App\Enums\Permission\PermissionName;
use App\Models\User;
use Carbon\Carbon;
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

        public bool $is_admin,

        public int $owner_id,

        public ?int $team_id,

        public string $first_name,

        public string $last_name,

        public string $full_name,

        public string $email,

        public ?string $phone,

        public ?int $creator_id,

        public ?Carbon $deleted_at,

        public Lazy|bool $is_owner,

        public Lazy|bool $is_member,

        public Lazy|bool $is_editor,

        public Lazy|bool $is_trashed,

        /** @var Lazy|array<PermissionName> */
        public Lazy|array $permissions,

        public Lazy|Optional|MediaResource $avatar,

        public Lazy|UserResource $owner,

        public Lazy|TeamListResource $team,

        #[DataCollectionOf(UserResource::class)]
        public Lazy|DataCollection $active_members,

        #[DataCollectionOf(UserResource::class)]
        public Lazy|DataCollection $members,

        #[DataCollectionOf(TeamListResource::class)]
        public Lazy|DataCollection $teams,
    ) {}

    public static function fromModel(User $user): static
    {
        return new static(
            id             : $user->id,
            is_admin       : $user->is_admin,
            owner_id       : $user->owner_id,
            team_id        : $user->team_id,
            first_name     : $user->first_name,
            last_name      : $user->last_name,
            full_name      : $user->full_name,
            email          : $user->email,
            phone          : $user->phone,
            creator_id     : $user->creator_id,
            deleted_at     : $user->deleted_at,
            is_owner       : Lazy::create(fn () => $user->is_owner),
            is_member      : Lazy::create(fn () => $user->is_member),
            is_editor      : Lazy::create(fn () => $user->is_editor),
            is_trashed     : Lazy::create(fn () => $user->is_trashed),
            permissions    : Lazy::create(fn () => $user->getAllPermissions()->map->name),
            avatar         : Lazy::whenLoaded('avatar', $user, fn () => MediaResource::from($user->avatar)),
            owner          : Lazy::whenLoaded('owner', $user, fn () => UserResource::from($user->owner)),
            team           : Lazy::whenLoaded('team', $user, fn () => TeamListResource::from($user->team)),
            active_members : Lazy::whenLoaded('activeMembers', $user, fn () => UserResource::collect($user->activeMembers)),
            members        : Lazy::whenLoaded('members', $user, fn () => UserResource::collect($user->members)),
            teams          : Lazy::whenLoaded('teams', $user, fn () => TeamListResource::collect($user->teams)),
        );
    }
}
