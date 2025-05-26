<?php

namespace App\Http\Controllers\Admin;

use App\Data\Banner\Admin\BannerAdminDeleteRequest;
use App\Data\Banner\Admin\BannerAdminIndexProps;
use App\Data\Banner\Admin\BannerAdminIndexRequest;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\ToastService;
use Illuminate\Http\Request;
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
        return Inertia::render('admin/banners/Index', BannerAdminIndexProps::from([
            'banners' => Banner::query()
                ->search($data->q)
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        //
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
            $this->toastService->error->execute(__('messages.error'));
        } finally {
        }

        return back();
    }
}
