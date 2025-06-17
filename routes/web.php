<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Banner\BannerDissmissController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\Settings\AppearanceSettingsController;
use App\Http\Controllers\Settings\PasswordSettingsController;
use App\Http\Controllers\Settings\ProfileSettingsController;
use App\Http\Controllers\Settings\SecuritySettingsController;
use App\Http\Controllers\Team\TeamController;
use App\Http\Controllers\Team\TeamFirstController;
use App\Http\Controllers\User\UserMemberController;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::post('/verification/code', [VerifyEmailController::class, 'code'])->name('verification.code')->middleware(['auth']);

Route::middleware(['auth', 'auth.no_team'])->group(function () {
    Route::prefix('/teams/first')->name('teams.first.')->controller(TeamFirstController::class)->group(function () {
        Route::get('/required', 'required')->name('required');
        Route::get('/create', 'create')->name('create')->middleware(['auth.owner']);
        Route::post('/create', 'store')->name('store')->middleware(['auth.owner']);
    });
});

Route::middleware(['auth', 'auth.team', 'auth.include', 'banner.include'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('index');

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

    Route::prefix('/teams')->name('teams.')->controller(TeamController::class)->group(function () {
        Route::get('/', 'index')->name('index')->can('viewAny', Team::class);
        Route::get('/create', 'create')->name('create')->can('create', Team::class);
        Route::post('/create', 'store')->name('store')->can('create', Team::class);
        Route::get('/edit/{team}', 'edit')->name('edit')->withTrashed()->can('view', 'team');
        Route::put('/edit/{team}', 'update')->name('update')->withTrashed()->can('update', 'team');
        Route::patch('/select/{team}', 'select')->name('select')->can('select', 'team');
        Route::delete('/trash/{team?}', 'trash')->name('trash');
        Route::patch('/restore/{team?}', 'restore')->name('restore');
        Route::delete('/delete/{team?}', 'destroy')->name('delete');
    });
    Route::name('users.')->group(function () {
        Route::prefix('/members')->name('members.')->controller(UserMemberController::class)->group(function () {
            Route::get('/', 'index')->name('index')->can('viewAny', User::class);
            Route::get('/create', 'create')->name('create')->can('create', User::class);
            Route::post('/create', 'store')->name('store')->can('create', User::class);
            Route::get('/edit/{member}', 'edit')->name('edit')->can('view', 'member');
            Route::put('/edit/{member}', 'update')->name('update')->can('update', 'member');
            Route::delete('/trash/{member?}', 'trash')->name('trash');
            Route::patch('/restore/{member?}', 'restore')->name('restore');
            Route::delete('/delete/{member?}', 'destroy')->name('delete');
        });
    });

});

require __DIR__.'/admin.php';
