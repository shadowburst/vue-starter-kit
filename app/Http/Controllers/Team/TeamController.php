<?php

namespace App\Http\Controllers\Team;

use App\Actions\Team\CreateOrUpdateTeam;
use App\Actions\User\SelectUserTeam;
use App\Data\Team\Form\TeamFormRequest;
use App\Data\Team\Index\TeamIndexRequest;
use App\Data\Team\TeamOneOrManyRequest;
use App\Data\Team\TeamResource;
use App\Enums\Trashed\TrashedFilter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Models\Team;
use App\Services\TeamService;
use App\Support\Toast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Spatie\LaravelData\PaginatedDataCollection;

class TeamController extends Controller
{
    public function index(TeamIndexRequest $data)
    {
        return Inertia::render('teams/Index', [
            'request' => $data,
            'teams'   => Inertia::optional(
                fn () => TeamResource::collect(
                    Auth::user()->teams()
                        ->search($data->q)
                        ->when($data->trashed, fn (Builder $q) => $q->filterTrashed($data->trashed))
                        ->orderBy($data->sort_by, $data->sort_direction)
                        ->with([
                            'logo',
                        ])
                        ->paginate(
                            perPage: $data->per_page ?? Config::integer('default.per_page'),
                            page: $data->page ?? 1,
                        )
                        ->withQueryString(),
                    PaginatedDataCollection::class,
                )->include(
                    'policy',
                    'logo',
                ),
            ),
            'trashedFilters' => Inertia::optional(fn () => TrashedFilter::labels()),
        ]);
    }

    public function create()
    {
        return Inertia::render('teams/Create', []);
    }

    public function store(TeamFormRequest $data)
    {
        $team = app(CreateOrUpdateTeam::class)->execute($data);

        if ($team == null) {
            Toast::error(__('messages.error'));

            return back();
        }

        Toast::success(__('messages.teams.store.success'));

        return to_action([TeamController::class, 'edit'], ['team' => $team]);
    }

    public function show(Team $team)
    {
        //
    }

    public function edit(Team $team)
    {
        app(TeamService::class)->setCurrent($team);

        return Inertia::render('teams/Edit', [
            'team' => $team->loadMissing([
                'logo',
            ]),
        ]);
    }

    public function update(Team $team, TeamFormRequest $data)
    {
        app(TeamService::class)->setCurrent($team);

        $team = app(CreateOrUpdateTeam::class)->execute($data, $team);

        if ($team == null) {
            Toast::error(__('messages.error'));

            return back();
        }

        Toast::success(__('messages.teams.update.success'));

        return to_action([TeamController::class, 'index']);
    }

    public function select(Team $team)
    {
        $success = app(SelectUserTeam::class)->execute(Auth::user(), $team);

        if (! $success) {
            Toast::error(__('messages.error'));

            return back();
        }

        Toast::success(__('messages.teams.select.success'));

        return to_action([DashboardController::class, 'index']);
    }

    public function trash(TeamOneOrManyRequest $data)
    {
        try {
            DB::beginTransaction();
            $count = Team::query()
                ->when($data->team, fn (Builder $q) => $q->where('id', $data->team))
                ->when($data->ids, fn (Builder $q) => $q->whereIntegerInRaw('id', $data->ids))
                ->get()
                ->each->delete();
            DB::commit();
            Toast::success(trans_choice('messages.teams.trash.success', $count));
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());
            DB::rollBack();
            Toast::error(__('messages.error'));
        }

        return back();
    }

    public function restore(TeamOneOrManyRequest $data)
    {
        try {
            DB::beginTransaction();
            $count = Team::query()
                ->onlyTrashed()
                ->when($data->team, fn (Builder $q) => $q->where('id', $data->team))
                ->when($data->ids, fn (Builder $q) => $q->whereIntegerInRaw('id', $data->ids))
                ->get()
                ->each->restore();
            DB::commit();
            Toast::success(trans_choice('messages.teams.restore.success', $count));
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());
            DB::rollBack();
            Toast::error(__('messages.error'));
        }

        return back();
    }

    public function destroy(TeamOneOrManyRequest $data)
    {
        try {
            DB::beginTransaction();
            $count = Team::query()
                ->withTrashed()
                ->when($data->team, fn (Builder $q) => $q->where('id', $data->team))
                ->when($data->ids, fn (Builder $q) => $q->whereIntegerInRaw('id', $data->ids))
                ->get()
                ->each->forceDelete();
            DB::commit();
            Toast::success(trans_choice('messages.teams.delete.success', $count));
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());
            DB::rollBack();
            Toast::error(__('messages.error'));
        }

        return back();
    }
}
