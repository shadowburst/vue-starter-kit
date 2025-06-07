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
        $team = $user->teams()->find($team->id);
        if (! $team) {
            return false;
        }

        // Already current team
        if ($user->team()->is($team) && $user->owner_id == $team->pivot->owner_id) {
            return true;
        }

        return $user->update([
            'team_id'  => $team->id,
            'owner_id' => $team->pivot->owner_id,
        ]);
    }
}
