<?php

namespace App\Http\Controllers\Team;

use App\Data\Team\Form\TeamFormRequest;
use App\Facades\Services;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class TeamFirstController extends Controller
{
    public function required()
    {
        return Inertia::render('teams/first/Required');
    }

    public function create()
    {
        return Inertia::render('teams/first/Create');
    }

    public function store(TeamFormRequest $data)
    {
        $team = Services::team()->createOrUpdate->execute($data);

        if ($team == null) {
            Services::toast()->error->execute();

            return back();
        }

        Services::toast()->success->execute(__('messages.teams.store.success'));

        return to_route('index');
    }
}
