<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Banner\BannerDissmissController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\Settings\AppearanceSettingsController;
use App\Http\Controllers\Settings\PasswordSettingsController;
use App\Http\Controllers\Settings\ProfileSettingsController;
use App\Http\Controllers\Settings\SecuritySettingsController;
use Illuminate\Support\Facades\Route;

Route::post('/verification/code', [VerifyEmailController::class, 'code'])->name('verification.code')->middleware(['auth']);

Route::middleware(['auth', 'banner.include'])->group(function () {
    Route::get('/', fn () => inertia('Index'))->name('index');

    Route::prefix('/banners')->name('banners.')->group(function () {
        Route::patch('/{banner}/dismiss', [BannerDissmissController::class, 'update'])->name('dismiss');
    });

    Route::prefix('/media')->name('media.')->controller(MediaController::class)->group(function () {
        Route::post('/{modelType}/{modelId}/{collection}', 'store')->name('store');
    });

    Route::prefix('/settings')->name('settings.')->group(function () {
        Route::redirect('/', '/settings/profile')->name('index');
        Route::prefix('/profile')->name('profile.')->controller(ProfileSettingsController::class)->group(function () {
            Route::get('/', 'edit')->name('edit');
            Route::patch('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('destroy');
        });
        Route::get('/security', [SecuritySettingsController::class, 'edit'])->name('security.edit');

        Route::prefix('/password')->name('password.')->controller(PasswordSettingsController::class)->group(function () {
            Route::patch('/', 'update')->name('update');
        });

        Route::get('/appearance', [AppearanceSettingsController::class, 'edit'])->name('appearance.edit');
    });
});

require __DIR__.'/admin.php';
