<?php

namespace App\Http\Controllers\Admin;

use App\Data\Banner\Admin\BannerAdminCreateProps;
use App\Data\Banner\Admin\BannerAdminDeleteRequest;
use App\Data\Banner\Admin\BannerAdminEditProps;
use App\Data\Banner\Admin\BannerAdminFormRequest;
use App\Data\Banner\Admin\BannerAdminIndexProps;
use App\Data\Banner\Admin\BannerAdminIndexRequest;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\ToastService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BannerAdminController extends Controller
{
    public function __construct(
        protected ToastService $toastService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(BannerAdminIndexRequest $data)
    {
        return Inertia::render('banners/admin/Index', BannerAdminIndexProps::from([
            'banners' => Banner::query()
                ->search($data->q)
                ->when($data->start_date, fn (Builder $q) => $q->where([
                    ['start_date', '>=', $data->start_date],
                    ['end_date', '>=', $data->start_date],
                ]))
                ->when($data->end_date, fn (Builder $q) => $q->where([
                    ['start_date', '<=', $data->end_date],
                    ['end_date', '<=', $data->end_date],
                ]))
                ->orderBy($data->sort_by, $data->sort_direction)
                ->paginate(
                    perPage: $data->per_page ?? Config::integer('default.per_page'),
                    page: $data->page ?? 1,
                )
                ->withQueryString(),
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('banners/admin/Create', BannerAdminCreateProps::from([
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerAdminFormRequest $data)
    {
        /** @var ?Banner $banner */
        $banner = Banner::create($data->toArray());

        $this->toastService->successOrError->execute($banner != null, __('messages.banners.store.success'));

        return to_route('admin.banners.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return Inertia::render('banners/admin/Edit', BannerAdminEditProps::from([
            'banner' => $banner,
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Banner $banner, BannerAdminFormRequest $data)
    {
        $success = $banner->update($data->toArray());

        $this->toastService->successOrError->execute($success, __('messages.banners.update.success'));

        return to_route('admin.banners.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BannerAdminDeleteRequest $data)
    {
        try {
            DB::beginTransaction();
            $count = $data->banners->each->delete();
            DB::commit();
            $this->toastService->success->execute(trans_choice('messages.banners.delete.success', $count));
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->toastService->error->execute();
        } finally {
        }

        return back();
    }
}
