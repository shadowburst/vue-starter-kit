<?php

use App\Http\Controllers\Banner\BannerAdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', fn () => inertia('Admin'))->name('index');
    Route::prefix('/banners')->name('banners.')->controller(BannerAdminController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::patch('/enable/{banner?}', 'enable')->name('enable');
        Route::patch('/disable/{banner?}', 'disable')->name('disable');
        Route::get('/{banner}/edit', 'edit')->name('edit');
        Route::put('/{banner}', 'update')->name('update');
        Route::delete('/{banner?}', 'destroy')->name('destroy');
    });
});
