<?php

namespace App\Http\Controllers\User;

use App\Data\User\UserCreateProps;
use App\Data\User\UserEditProps;
use App\Data\User\UserFormRequest;
use App\Data\User\UserIndexProps;
use App\Data\User\UserIndexRequest;
use App\Data\User\UserIndexResource;
use App\Data\User\UserOneOrManyOnlyTrashedRequest;
use App\Data\User\UserOneOrManyRequest;
use App\Data\User\UserOneOrManyWithTrashedRequest;
use App\Facades\Services;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\PaginatedDataCollection;

class UserController extends Controller
{
    public function index(UserIndexRequest $data)
    {
        return Inertia::render('users/Index', UserIndexProps::from([
            'request' => $data,
            'users'   => Lazy::inertia(
                fn () => UserIndexResource::collect(
                    Auth::user()->members()
                        ->belongsToAnyTeam()
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
        ]));
    }

    public function create()
    {
        return Inertia::render('users/Create', UserCreateProps::from([]));
    }

    public function store(UserFormRequest $data)
    {
        /** @var ?User $user */
        $user = Auth::user()->members()->create($data->toArray());

        if (is_null($user)) {
            Services::toast()->error->execute();

            return back();

        }

        Services::toast()->success->execute(__('messages.users.store.success'));

        return to_route('users.edit', $user);
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $member)
    {
        return Inertia::render('users/Edit', UserEditProps::from([
            'user' => $member,
        ]));
    }

    public function update(User $member, UserFormRequest $data)
    {
        $success = $member->update($data->exceptWhen('password', is_null($data->password))->toArray());

        Services::toast()->successOrError->execute($success, __('messages.users.update.success'));

        return to_route('users.index');
    }

    public function trash(UserOneOrManyRequest $data)
    {
        try {
            DB::beginTransaction();
            $count = $data->users->each->delete();
            DB::commit();
            Services::toast()->success->execute(trans_choice('messages.users.trash.success', $count));
        } catch (\Throwable $e) {
            DB::rollBack();
            Services::toast()->error->execute();
        } finally {
        }

        return back();
    }

    public function restore(UserOneOrManyOnlyTrashedRequest $data)
    {
        try {
            DB::beginTransaction();
            $count = $data->users->each->restore();
            DB::commit();
            Services::toast()->success->execute(trans_choice('messages.users.restore.success', $count));
        } catch (\Throwable $e) {
            DB::rollBack();
            Services::toast()->error->execute();
        } finally {
        }

        return back();
    }

    public function destroy(UserOneOrManyWithTrashedRequest $data)
    {
        try {
            DB::beginTransaction();
            $count = $data->users->each->forceDelete();
            DB::commit();
            Services::toast()->success->execute(trans_choice('messages.users.delete.success', $count));
        } catch (\Throwable $e) {
            DB::rollBack();
            Services::toast()->error->execute();
        } finally {
        }

        return back();
    }
}
