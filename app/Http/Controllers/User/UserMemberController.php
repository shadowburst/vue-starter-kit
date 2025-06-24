<?php

namespace App\Http\Controllers\User;

use App\Data\User\Member\Form\UserMemberFormProps;
use App\Data\User\Member\Form\UserMemberFormRequest;
use App\Data\User\Member\Index\UserMemberIndexProps;
use App\Data\User\Member\Index\UserMemberIndexRequest;
use App\Data\User\Member\Index\UserMemberIndexResource;
use App\Data\User\Member\UserMemberOneOrManyRequest;
use App\Enums\Permission\PermissionName;
use App\Enums\Trashed\TrashedFilter;
use App\Facades\Services;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\PaginatedDataCollection;

class UserMemberController extends Controller
{
    public function index(UserMemberIndexRequest $data)
    {
        return Inertia::render('users/members/Index', UserMemberIndexProps::from([
            'request' => $data,
            'users'   => Lazy::inertia(
                fn () => UserMemberIndexResource::collect(
                    Auth::user()->members()
                        ->search($data->q)
                        ->when($data->trashed, fn (Builder $q) => $q->filterTrashed($data->trashed))
                        ->orderBy($data->sort_by, $data->sort_direction)
                        ->with(['avatar'])
                        ->paginate(
                            perPage: $data->per_page ?? Config::integer('default.per_page'),
                            page: $data->page ?? 1,
                        )
                        ->withQueryString(),
                    PaginatedDataCollection::class,
                ),
            ),
            'trashedFilters' => Lazy::inertia(fn () => TrashedFilter::labels()),
        ]));
    }

    public function create()
    {
        $user = Auth::user();

        return Inertia::render('users/members/Create', UserMemberFormProps::from([
            'teams'       => Lazy::closure(fn () => $user->teams),
            'permissions' => Lazy::closure(fn () => PermissionName::labels($user->getAllPermissions()->map->name)),
        ]));
    }

    public function store(UserMemberFormRequest $data)
    {
        $user = Services::user()->createOrUpdateMember->execute($data);

        if ($user == null) {
            Services::toast()->error->execute();

            return back();
        }

        Services::toast()->success->execute(__('messages.users.members.store.success'));

        return to_route('users.members.index');
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $member)
    {
        $user = Auth::user();

        return Inertia::render('users/members/Edit', UserMemberFormProps::from([
            'user'        => $member->load(['avatar']),
            'teams'       => Lazy::closure(fn () => $user->teams),
            'permissions' => Lazy::closure(fn () => PermissionName::labels($user->getAllPermissions()->map->name)),
        ]));
    }

    public function update(UserMemberFormRequest $data)
    {
        $user = Services::user()->createOrUpdateMember->execute($data);

        if ($user == null) {
            Services::toast()->error->execute();

            return back();
        }

        Services::toast()->success->execute(__('messages.users.members.update.success'));

        return to_route('users.members.index');
    }

    public function trash(UserMemberOneOrManyRequest $data)
    {
        try {
            DB::beginTransaction();
            $count = Auth::user()->members()
                ->when($data->user, fn (Builder $q) => $q->where('id', $data->user))
                ->when($data->ids, fn (Builder $q) => $q->whereIntegerInRaw('id', $data->ids))
                ->get()
                ->each->delete();
            DB::commit();
            Services::toast()->success->execute(trans_choice('messages.users.members.trash.success', $count));
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());
            DB::rollBack();
            Services::toast()->error->execute();
        }

        return back();
    }

    public function restore(UserMemberOneOrManyRequest $data)
    {
        try {
            DB::beginTransaction();
            $count = Auth::user()->members()
                ->onlyTrashed()
                ->when($data->user, fn (Builder $q) => $q->where('id', $data->user))
                ->when($data->ids, fn (Builder $q) => $q->whereIntegerInRaw('id', $data->ids))
                ->get()
                ->each->restore();
            DB::commit();
            Services::toast()->success->execute(trans_choice('messages.users.members.restore.success', $count));
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());
            DB::rollBack();
            Services::toast()->error->execute();
        }

        return back();
    }

    public function destroy(UserMemberOneOrManyRequest $data)
    {
        try {
            DB::beginTransaction();
            $count = Auth::user()->members()
                ->withTrashed()
                ->when($data->user, fn (Builder $q) => $q->where('id', $data->user))
                ->when($data->ids, fn (Builder $q) => $q->whereIntegerInRaw('id', $data->ids))
                ->get()
                ->each->forceDelete();
            DB::commit();
            Services::toast()->success->execute(trans_choice('messages.users.members.delete.success', $count));
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());
            DB::rollBack();
            Services::toast()->error->execute();
        }

        return back();
    }
}
