<?php

namespace App\Http\Controllers\Team;

use App\Data\Team\Form\TeamFormProps;
use App\Data\Team\Form\TeamFormRequest;
use App\Data\Team\Index\TeamIndexProps;
use App\Data\Team\Index\TeamIndexRequest;
use App\Data\Team\Index\TeamIndexResource;
use App\Data\Team\TeamOneOrManyRequest;
use App\Enums\Trashed\TrashedFilter;
use App\Facades\Services;
use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            'trashed_filters' => Lazy::inertia(fn () => TrashedFilter::labels()),
        ]));
    }

    public function create()
    {
        return Inertia::render('teams/Create', TeamFormProps::from([]));
    }

    public function store(TeamFormRequest $data)
    {
        $team = Services::team()->createOrUpdate->execute($data);

        if ($team == null) {
            Services::toast()->error->execute();

            return back();
        }

        Services::toast()->success->execute(__('messages.teams.store.success'));

        return to_route('teams.edit', $team);
    }

    public function show(Team $team)
    {
        //
    }

    public function edit(Team $team)
    {
        return Inertia::render('teams/Edit', TeamFormProps::from([
            'team' => $team,
        ]));
    }

    public function update(Team $team, TeamFormRequest $data)
    {
        $team = Services::team()->createOrUpdate->execute($data);

        if ($team == null) {
            Services::toast()->error->execute();

            return back();
        }

        Services::toast()->success->execute(__('messages.teams.update.success'));

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
            $count = Team::query()
                ->when($data->team, fn (Builder $q) => $q->where('id', $data->team))
                ->when($data->ids, fn (Builder $q) => $q->whereIntegerInRaw('id', $data->ids))
                ->get()
                ->each->delete();
            DB::commit();
            Services::toast()->success->execute(trans_choice('messages.teams.trash.success', $count));
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());
            DB::rollBack();
            Services::toast()->error->execute();
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
            Services::toast()->success->execute(trans_choice('messages.teams.restore.success', $count));
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());
            DB::rollBack();
            Services::toast()->error->execute();
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
            Services::toast()->success->execute(trans_choice('messages.teams.delete.success', $count));
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());
            DB::rollBack();
            Services::toast()->error->execute();
        }

        return back();
    }
}
