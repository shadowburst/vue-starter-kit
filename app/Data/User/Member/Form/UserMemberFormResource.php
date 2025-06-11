<?php

namespace App\Data\User\Member\Form;

use App\Data\Media\MediaResource;
use App\Facades\Services;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserMemberFormResource extends Resource
{
    public function __construct(
        public int $id,
        public string $first_name,
        public string $last_name,
        public string $email,
        public ?string $phone,
        public bool $can_view,
        public bool $can_update,
        public bool $can_trash,
        public bool $can_restore,
        public bool $can_delete,

        public ?MediaResource $avatar,

        #[DataCollectionOf(UserMemberFormTeamRoleData::class)]
        public DataCollection $team_roles,

        #[DataCollectionOf(UserMemberFormTeamPermissionData::class)]
        public DataCollection $team_permissions,
    ) {}

    public static function fromModel(User $user): self
    {
        $teamRoles = collect();
        $teamPermissions = collect();

        foreach ($user->teams as $team) {
            Services::team()->forTeam(
                $team,
                function (Team $team) use ($user, $teamRoles, $teamPermissions) {
                    $user->unsetRolesAndPermissions();
                    $teamRoles->push(...$user->roles->map(fn (Role $role) => [
                        'team_id' => $team->id,
                        'role'    => $role->name,
                    ]));
                    $teamPermissions->push(...$user->getDirectPermissions()->map(fn (Permission $permission) => [
                        'team_id'    => $team->id,
                        'permission' => $permission->name,
                    ]));
                },
            );
        }

        return self::from([
            'id'               => $user->id,
            'first_name'       => $user->first_name,
            'last_name'        => $user->last_name,
            'email'            => $user->email,
            'phone'            => $user->phone,
            'can_view'         => $user->can_view,
            'can_update'       => $user->can_update,
            'can_trash'        => $user->can_trash,
            'can_restore'      => $user->can_restore,
            'can_delete'       => $user->can_delete,
            'avatar'           => $user->avatar,
            'team_roles'       => $teamRoles,
            'team_permissions' => $teamPermissions,
        ]);
    }
}
