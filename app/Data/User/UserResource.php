<?php

namespace App\Data\User;

use App\Data\Media\MediaResource;
use App\Data\Team\TeamResource;
use App\Data\User\Team\UserTeamPermissionData;
use App\Data\User\Team\UserTeamRoleData;
use App\Enums\Permission\PermissionName;
use App\Facades\Services;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Team;
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

        public Lazy|bool $can_view,

        public Lazy|bool $can_update,

        public Lazy|bool $can_trash,

        public Lazy|bool $can_restore,

        public Lazy|bool $can_delete,

        /** @var Lazy|array<PermissionName> */
        public Lazy|array $permissions,

        public Lazy|Optional|MediaResource $avatar,

        public Lazy|UserResource $owner,

        public Lazy|TeamResource $team,

        #[DataCollectionOf(UserResource::class)]
        public Lazy|DataCollection $active_members,

        #[DataCollectionOf(UserResource::class)]
        public Lazy|DataCollection $members,

        #[DataCollectionOf(TeamResource::class)]
        public Lazy|DataCollection $teams,

        #[DataCollectionOf(UserTeamRoleData::class)]
        public Lazy|DataCollection $team_roles,

        #[DataCollectionOf(UserTeamPermissionData::class)]
        public Lazy|DataCollection $team_permissions,
    ) {}

    public static function fromModel(User $user): static
    {
        return static::from([
            'id'             => $user->id,
            'is_admin'       => $user->is_admin,
            'owner_id'       => $user->owner_id,
            'team_id'        => $user->team_id,
            'first_name'     => $user->first_name,
            'last_name'      => $user->last_name,
            'full_name'      => $user->full_name,
            'email'          => $user->email,
            'phone'          => $user->phone,
            'creator_id'     => $user->creator_id,
            'deleted_at'     => $user->deleted_at,
            'is_owner'       => Lazy::create(fn () => $user->is_owner),
            'is_member'      => Lazy::create(fn () => $user->is_member),
            'is_editor'      => Lazy::create(fn () => $user->is_editor),
            'is_trashed'     => Lazy::create(fn () => $user->is_trashed),
            'can_view'       => Lazy::create(fn () => $user->can_view),
            'can_update'     => Lazy::create(fn () => $user->can_update),
            'can_trash'      => Lazy::create(fn () => $user->can_trash),
            'can_restore'    => Lazy::create(fn () => $user->can_restore),
            'can_delete'     => Lazy::create(fn () => $user->can_delete),
            'permissions'    => Lazy::create(fn () => $user->getAllPermissions()->map->name),
            'avatar'         => Lazy::create(fn () => $user->avatar ? MediaResource::from($user->avatar) : Optional::create()),
            'owner'          => Lazy::create(fn () => UserResource::from($user->owner)),
            'team'           => Lazy::create(fn () => TeamResource::from($user->team)),
            'active_members' => Lazy::create(fn () => UserResource::collect($user->activeMembers)),
            'members'        => Lazy::create(fn () => UserResource::collect($user->members)),
            'teams'          => Lazy::create(fn () => TeamResource::collect($user->teams)),
            'team_roles'     => Lazy::create(
                function () use ($user) {
                    $teamRoles = collect();

                    Services::team()->forEachTeam(
                        $user->teams,
                        function (Team $team) use ($user, $teamRoles) {
                            $user->unsetRelation('roles');
                            $teamRoles->push(...$user->roles->map(
                                fn (Role $role) => [
                                    'team_id' => $team->id,
                                    'role'    => $role->name,
                                ],
                            ));
                        },
                    );

                    return UserTeamRoleData::collect($teamRoles);
                },
            ),
            'team_permissions' => Lazy::create(
                function () use ($user) {
                    $teamPermissions = collect();

                    Services::team()->forEachTeam(
                        $user->teams,
                        function (Team $team) use ($user, $teamPermissions) {
                            $user->unsetRelation('permissions');
                            $teamPermissions->push(...$user->getDirectPermissions()->map(
                                fn (Permission $permission) => [
                                    'team_id'    => $team->id,
                                    'permission' => $permission->name,
                                ],
                            ));
                        },
                    );

                    return UserTeamPermissionData::collect($teamPermissions);
                },
            ),
        ], );
    }
}
