<?php

namespace App\Http\Controllers\Banner;

use App\Data\Banner\Admin\Form\BannerAdminFormProps;
use App\Data\Banner\Admin\Form\BannerAdminFormRequest;
use App\Data\Banner\Admin\Index\BannerAdminIndexProps;
use App\Data\Banner\Admin\Index\BannerAdminIndexRequest;
use App\Data\Banner\BannerOneOrManyRequest;
use App\Data\Banner\BannerResource;
use App\Facades\Services;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\PaginatedDataCollection;

class BannerAdminController extends Controller
{
    public function index(BannerAdminIndexRequest $data)
    {
        return Inertia::render('banners/admin/Index', BannerAdminIndexProps::from([
            'banners' => Lazy::inertia(
                fn () => BannerResource::collect(
                    Banner::query()
                        ->search($data->q)
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
        return Inertia::render('banners/admin/Create', BannerAdminFormProps::from([]));
    }

    public function store(BannerAdminFormRequest $data)
    {
        /** @var ?Banner $banner */
        $banner = Banner::create($data->toArray());

        Services::toast()->successOrError->execute($banner != null, __('messages.banners.store.success'));

        return to_route('admin.banners.index');
    }

    public function show(Banner $banner)
    {
        //
    }

    public function edit(Banner $banner)
    {
        return Inertia::render('banners/admin/Edit', BannerAdminFormProps::from([
            'banner' => $banner,
        ]));
    }

    public function update(Banner $banner, BannerAdminFormRequest $data)
    {
        $success = $banner->update($data->toArray());

        Services::toast()->successOrError->execute($success, __('messages.banners.update.success'));

        return to_route('admin.banners.index');
    }

    public function enable(BannerOneOrManyRequest $data)
    {
        Banner::query()
            ->when($data->banner, fn (Builder $q) => $q->where('id', $data->banner))
            ->when($data->ids, fn (Builder $q) => $q->whereIntegerInRaw('id', $data->ids))
            ->get()
            ->each->update([
                'is_enabled' => true,
            ]);

        return back();
    }

    public function disable(BannerOneOrManyRequest $data)
    {
        Banner::query()
            ->when($data->banner, fn (Builder $q) => $q->where('id', $data->banner))
            ->when($data->ids, fn (Builder $q) => $q->whereIntegerInRaw('id', $data->ids))
            ->get()
            ->each->update([
                'is_enabled' => false,
            ]);

        return back();
    }

    public function destroy(BannerOneOrManyRequest $data)
    {
        try {
            DB::beginTransaction();
            $count = Banner::query()
                ->when($data->banner, fn (Builder $q) => $q->where('id', $data->banner))
                ->when($data->ids, fn (Builder $q) => $q->whereIntegerInRaw('id', $data->ids))
                ->get()
                ->each->delete();
            DB::commit();
            Services::toast()->success->execute(trans_choice('messages.banners.delete.success', $count));
        } catch (\Throwable $e) {
            DB::rollBack();
            Services::toast()->error->execute();
        }

        return back();
    }
}
