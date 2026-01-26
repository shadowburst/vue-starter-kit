<?php

namespace App\Actions\Team;

use App\Actions\Media\UpdateMedia;
use App\Data\Team\Form\TeamFormRequest;
use App\Enums\Role\RoleName;
use App\Models\Team;
use App\Services\TeamService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\QueueableAction\QueueableAction;

class CreateOrUpdateTeam
{
    use QueueableAction;

    public function __construct(
        //
    ) {}

    public function execute(TeamFormRequest $data, ?Team $team = null): ?Team
    {
        DB::beginTransaction();

        try {
            if (! $team) {
                /** @var Team $team */
                $team = Team::create($data->toArray());
            } else {
                $team->update($data->toArray());
            }

            if ($team->wasRecentlyCreated && $data->user) {
                app(TeamService::class)->forTeam($team, fn () => $data->user->assignRole(RoleName::OWNER));
            } else {
                app(UpdateMedia::class)->execute($team, Team::COLLECTION_LOGO, $data->logo);
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
