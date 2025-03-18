<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => inertia('Welcome'))->name('home');

Route::middleware(['auth'])->group(function () {
    Route::post('verification/code', [VerifyEmailController::class, 'code'])->name('verification.code');
    Route::middleware(['verified'])->group(function () {
        Route::get('dashboard', fn () => inertia('Dashboard'))->name('dashboard');
    });
});
