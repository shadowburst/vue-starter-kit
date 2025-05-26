<?php

use App\Http\Controllers\Admin\BannerAdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', fn () => inertia('admin/Home'))->name('home');
    Route::prefix('/banners')->name('banners.')->controller(BannerAdminController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{banner}', 'edit')->name('edit');
        Route::put('/{banner}', 'update')->name('update');
        Route::delete('/{banner?}', 'destroy')->name('destroy');
    });
});
