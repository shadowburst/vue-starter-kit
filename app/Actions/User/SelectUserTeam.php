<?php

namespace App\Actions\User;

use App\Models\Team;
use App\Models\User;
use Spatie\QueueableAction\QueueableAction;

class SelectUserTeam
{
    use QueueableAction;

    public function __construct(
        //
    ) {}

    public function execute(User $user, Team $team): bool
    {
        $team = $user->teams->find($team->id);
        if (! $team) {
            return false;
        }

        // Already current team
        if ($user->team()->is($team)) {
            return true;
        }

        $success = $user->update([
            'team_id' => $team->id,
        ]);
        if (! $success) {
            return false;
        }

        $user->unsetRolesAndPermissions();
        $user->unsetRelation('team');

        return true;
    }
}
