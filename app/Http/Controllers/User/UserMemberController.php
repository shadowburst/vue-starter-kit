<?php

namespace App\Http\Controllers\User;

use App\Actions\User\Member\CreateOrUpdateMemberUser;
use App\Data\Team\TeamResource;
use App\Data\User\Member\Form\UserMemberFormRequest;
use App\Data\User\Member\Index\UserMemberIndexRequest;
use App\Data\User\Member\UserMemberOneOrManyRequest;
use App\Data\User\UserResource;
use App\Enums\Permission\PermissionName;
use App\Enums\Trashed\TrashedFilter;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Toast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\PaginatedDataCollection;

class UserMemberController extends Controller
{
    public function index(UserMemberIndexRequest $data)
    {
        return Inertia::render('users/members/Index', [
            'request' => $data,
            'users'   => Inertia::optional(
                fn () => UserResource::collect(
                    Auth::user()->members()
                        ->search($data->q)
                        ->when($data->trashed, fn (Builder $q) => $q->filterTrashed($data->trashed))
                        ->with(['avatar'])
                        ->paginate(
                            page: $data->page,
                            perPage: $data->per_page,
                        )
                        ->withQueryString(),
                    PaginatedDataCollection::class,
                )
                    ->include(
                        'policy',
                        'avatar',
                    ),
            ),
            'trashedFilters' => Lazy::inertia(fn () => TrashedFilter::labels()),
        ]);
    }

    public function create()
    {
        $user = Auth::user();

        return Inertia::render('users/members/Create', [
            'teams'       => fn () => $user->teams,
            'permissions' => fn () => PermissionName::labels($user->getAllPermissions()->map->name),
        ]);
    }

    public function store(UserMemberFormRequest $data)
    {
        $user = app(CreateOrUpdateMemberUser::class)->execute($data);

        if ($user == null) {
            Toast::error(__('messages.error'));

            return back();
        }

        Toast::success(__('messages.users.members.store.success'));

        return to_action([static::class, 'index']);
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $member)
    {
        $user = Auth::user();

        return Inertia::render('users/members/Edit', [
            'user' => UserResource::from($member->load(['avatar']))->include(
                'policy',
                'avatar',
                'team_roles',
                'team_permissions',
            ),
            'teams'       => fn () => TeamResource::collect($user->teams),
            'permissions' => fn () => PermissionName::labels($user->getAllPermissions()->map->name),
        ]);
    }

    public function update(UserMemberFormRequest $data, User $member)
    {
        $user = app(CreateOrUpdateMemberUser::class)->execute($data, $member);

        if ($user == null) {
            Toast::error(__('messages.error'));

            return back();
        }

        Toast::success(__('messages.users.members.update.success'));

        return to_action([static::class, 'index']);
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
            Toast::success(trans_choice('messages.users.members.trash.success', $count));
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());
            DB::rollBack();
            Toast::error(__('messages.error'));
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
            Toast::success(trans_choice('messages.users.members.restore.success', $count));
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());
            DB::rollBack();
            Toast::error(__('messages.error'));
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
            Toast::success(trans_choice('messages.users.members.delete.success', $count));
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());
            DB::rollBack();
            Toast::error(__('messages.error'));
        }

        return back();
    }
}
