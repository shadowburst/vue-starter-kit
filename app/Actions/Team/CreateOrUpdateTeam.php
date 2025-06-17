<?php

namespace App\Actions\Team;

use App\Data\Team\Form\TeamFormRequest;
use App\Enums\Role\RoleName;
use App\Facades\Services;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\QueueableAction\QueueableAction;

class CreateOrUpdateTeam
{
    use QueueableAction;

    public function __construct(
        //
    ) {}

    public function execute(TeamFormRequest $data): ?Team
    {
        DB::beginTransaction();

        $team = $data->team;

        try {
            if (! $team) {
                /** @var Team $team */
                $team = Team::create($data->toArray());
            } else {
                $team->update($data->toArray());
            }

            if ($team->wasRecentlyCreated && $data->user) {
                Services::team()->forTeam($team, fn () => $data->user->assignRole(RoleName::OWNER));
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());
            DB::rollBack();

            return null;
        }

        DB::commit();

        return $team;
    }
}
