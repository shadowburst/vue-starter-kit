<?php

use App\Http\Controllers\Banner\BannerAdminController;
use App\Http\Controllers\User\UserAdminController;
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
        Route::delete('/{banner?}', 'destroy')->name('delete');
    });
    Route::prefix('/users')->name('users.')->controller(UserAdminController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::delete('/trash/{user?}', 'trash')->name('trash');
        Route::patch('/restore/{user?}', 'restore')->name('restore');
        Route::delete('/delete/{user?}', 'destroy')->name('delete');
        Route::get('/{user}/edit', 'edit')->name('edit')->withTrashed();
        Route::put('/{user}', 'update')->name('update')->withTrashed();
    });
});
