<?php

namespace App\Http\Controllers\User;

use App\Data\User\Admin\UserAdminCreateProps;
use App\Data\User\Admin\UserAdminEditProps;
use App\Data\User\Admin\UserAdminFormRequest;
use App\Data\User\Admin\UserAdminIndexProps;
use App\Data\User\Admin\UserAdminIndexRequest;
use App\Data\User\Admin\UserAdminIndexResource;
use App\Data\User\UserOneOrManyRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ToastService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\PaginatedDataCollection;

class UserAdminController extends Controller
{
    public function __construct(
        protected ToastService $toastService,
    ) {}

    public function index(UserAdminIndexRequest $data)
    {
        return Inertia::render('users/admin/Index', UserAdminIndexProps::from([
            'users' => Lazy::inertia(
                fn () => UserAdminIndexResource::collect(
                    User::query()
                        ->search($data->q)
                        ->when($data->with_trashed, fn (Builder $q) => $q->withTrashed())
                        ->orderBy($data->sort_by, $data->sort_direction)
                        ->with([
                            'avatar',
                        ])
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
        return Inertia::render('users/admin/Create', UserAdminCreateProps::from([]));
    }

    public function store(UserAdminFormRequest $data)
    {
        /** @var ?User $user */
        $user = User::create($data->toArray());

        $this->toastService->successOrError->execute($user != null, __('messages.users.store.success'));

        return to_route('admin.users.index');
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        return Inertia::render('users/admin/Edit', UserAdminEditProps::from([
            'user' => $user,
        ]));
    }

    public function update(User $user, UserAdminFormRequest $data)
    {
        $success = $user->update($data->toArray());

        $this->toastService->successOrError->execute($success, __('messages.users.update.success'));

        return to_route('admin.users.index');
    }

    public function destroy(UserOneOrManyRequest $data)
    {
        try {
            DB::beginTransaction();
            $count = $data->users->toQuery()->delete();
            DB::commit();
            $this->toastService->success->execute(trans_choice('messages.users.delete.success', $count));
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->toastService->error->execute();
        } finally {
        }

        return back();
    }
}
