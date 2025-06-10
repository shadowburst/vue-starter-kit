<?php

namespace App\Data\User\Member\Form;

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
                    $user->resetRolesAndPermissions();
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
            'team_roles'       => $teamRoles,
            'team_permissions' => $teamPermissions,
        ]);
    }
}
