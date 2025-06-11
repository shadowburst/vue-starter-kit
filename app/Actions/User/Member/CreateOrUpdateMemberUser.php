<?php

namespace App\Actions\User\Member;

use App\Data\User\Member\Form\UserMemberFormRequest;
use App\Facades\Services;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\QueueableAction\QueueableAction;

class CreateOrUpdateMemberUser
{
    use QueueableAction;

    public function __construct(
        //
    ) {}

    public function execute(UserMemberFormRequest $data): ?User
    {
        DB::beginTransaction();

        try {
            $owner = $data->owner;
            $user = $data->member;
            if (! $user?->exists) {
                $user = $owner->members()->create($data->toArray());
            } else {
                $user->update($data->except('member')->exceptWhen('password', is_null($data->password))->toArray());
                Services::media()->update->execute($user, User::COLLECTION_AVATAR, $data->avatar);
            }

            /** @var User $user */
            Services::team()->forEachTeam(
                $owner->teams,
                function () use ($user) {
                    $user->syncRoles();
                    $user->syncPermissions();
                },
            );

            $user->unsetRolesAndPermissions();

            /** @var UserMemberFormTeamRoleData $teamRole */
            foreach ($data->team_roles as $teamRole) {
                Services::team()->forTeam(
                    $teamRole->team_id,
                    fn () => $user->assignRole($teamRole->role),
                );
            }

            /** @var UserMemberFormTeamPermissionData $teamPermission */
            foreach ($data->team_permissions as $teamPermission) {
                // Only give permissions if given access to the team
                if ($data->team_roles->toCollection()->map->team_id->contains($teamPermission->team_id)) {
                    Services::team()->forTeam(
                        $teamPermission->team_id,
                        fn () => $user->givePermissionTo($teamPermission->permission),
                    );
                }
            }

            DB::commit();

            return $user;
        } catch (\Throwable $th) {
            DB::rollBack();

            return null;
        }
    }
}
