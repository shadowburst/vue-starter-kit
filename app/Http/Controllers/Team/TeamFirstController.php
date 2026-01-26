<?php

namespace App\Http\Controllers\Team;

use App\Actions\Team\CreateOrUpdateTeam;
use App\Data\Team\Form\TeamFormRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Support\Toast;
use Inertia\Inertia;

class TeamFirstController extends Controller
{
    public function required()
    {
        return Inertia::render('teams/first/Required', []);
    }

    public function create()
    {
        return Inertia::render('teams/first/Create', []);
    }

    public function store(TeamFormRequest $data)
    {
        $team = app(CreateOrUpdateTeam::class)->execute($data);

        if ($team == null) {
            Toast::error(__('messages.error'));

            return back();
        }

        Toast::success(__('messages.teams.store.success'));

        return to_action([DashboardController::class, 'index']);
    }
}
