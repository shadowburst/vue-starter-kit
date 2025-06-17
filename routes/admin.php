<?php

use App\Http\Controllers\Banner\BannerAdminController;
use App\Http\Controllers\Dashboard\DashboardAdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->name('admin.')->middleware(['auth', 'auth.team', 'auth.include'])->group(function () {

    Route::get('/', [DashboardAdminController::class, 'index'])->name('index');

    Route::prefix('/banners')->name('banners.')->controller(BannerAdminController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('store');
        Route::get('/edit/{banner}', 'edit')->name('edit');
        Route::put('/edit/{banner}', 'update')->name('update');
        Route::patch('/enable/{banner?}', 'enable')->name('enable');
        Route::patch('/disable/{banner?}', 'disable')->name('disable');
        Route::delete('/delete/{banner?}', 'destroy')->name('delete');
    });

});
