<?php

use App\Http\Controllers\Admin\BannerAdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', fn () => inertia('admin/Home'))->name('home');
    Route::resource('banners', BannerAdminController::class);
});
