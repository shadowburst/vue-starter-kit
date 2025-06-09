<?php

namespace App\Http\Controllers\Team;

use App\Data\Team\TeamCreateProps;
use App\Data\Team\TeamEditProps;
use App\Data\Team\TeamFormRequest;
use App\Data\Team\TeamIndexProps;
use App\Data\Team\TeamIndexRequest;
use App\Data\Team\TeamIndexResource;
use App\Data\Team\TeamOneOrManyOnlyTrashedRequest;
use App\Data\Team\TeamOneOrManyRequest;
use App\Data\Team\TeamOneOrManyWithTrashedRequest;
use App\Facades\Services;
use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\PaginatedDataCollection;

class TeamController extends Controller
{
    public function index(TeamIndexRequest $data)
    {
        return Inertia::render('teams/Index', TeamIndexProps::from([
            'request' => $data,
            'teams'   => Lazy::inertia(
                fn () => TeamIndexResource::collect(
                    Auth::user()->teams()
                        ->search($data->q)
                        ->when($data->trashed, fn (Builder $q) => $q->filterTrashed($data->trashed))
                        ->orderBy($data->sort_by, $data->sort_direction)
                        ->paginate(
                            perPage: $data->per_page ?? Config::integer('default.per_page'),
                            page: $data->page ?? 1,
                        )
                        ->withQueryString(),
                    PaginatedDataCollection::class,
                ),
            ),
        ]));
    }

    public function create()
    {
        return Inertia::render('teams/Create', TeamCreateProps::from([]));
    }

    public function store(TeamFormRequest $data)
    {
        /** @var ?Team $team */
        $team = Team::create($data->toArray());

        Services::toast()->successOrError->execute($team != null, __('messages.teams.store.success'));

        return to_route('teams.index');
    }

    public function show(Team $team)
    {
        //
    }

    public function edit(Team $team)
    {
        return Inertia::render('teams/Edit', TeamEditProps::from([
            'team' => $team,
        ]));
    }

    public function update(Team $team, TeamFormRequest $data)
    {
        $success = $team->update($data->toArray());

        Services::toast()->successOrError->execute($success, __('messages.teams.update.success'));

        return to_route('teams.index');
    }

    public function select(Team $team)
    {
        $success = Services::user()->selectTeam->execute(Auth::user(), $team);

        Services::toast()->successOrError->execute($success, __('messages.teams.select.success'));

        return to_route('index');
    }

    public function trash(TeamOneOrManyRequest $data)
    {
        try {
            DB::beginTransaction();
            $count = $data->teams->each->delete();
            DB::commit();
            Services::toast()->success->execute(trans_choice('messages.teams.trash.success', $count));
        } catch (\Throwable $e) {
            DB::rollBack();
            Services::toast()->error->execute();
        } finally {
        }

        return back();
    }

    public function restore(TeamOneOrManyOnlyTrashedRequest $data)
    {
        try {
            DB::beginTransaction();
            $count = $data->teams->each->restore();
            DB::commit();
            Services::toast()->success->execute(trans_choice('messages.teams.restore.success', $count));
        } catch (\Throwable $e) {
            DB::rollBack();
            Services::toast()->error->execute();
        } finally {
        }

        return back();
    }

    public function destroy(TeamOneOrManyWithTrashedRequest $data)
    {
        try {
            DB::beginTransaction();
            $count = $data->teams->each->forceDelete();
            DB::commit();
            Services::toast()->success->execute(trans_choice('messages.teams.delete.success', $count));
        } catch (\Throwable $e) {
            DB::rollBack();
            Services::toast()->error->execute();
        } finally {
        }

        return back();
    }
}
