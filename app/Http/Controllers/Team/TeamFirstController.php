<?php

namespace App\Http\Controllers\Team;

use App\Data\Team\Form\TeamFormRequest;
use App\Facades\Services;
use App\Http\Controllers\Controller;
use App\Models\Team;
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
        /** @var ?Team $team */
        $team = Team::create($data->toArray());

        Services::toast()->successOrError->execute($team != null, __('messages.teams.store.success'));

        return to_route('index');
    }
}
