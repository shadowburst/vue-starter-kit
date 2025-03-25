<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::post('/verification/code', [VerifyEmailController::class, 'code'])->name('verification.code')->middleware(['auth']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', fn () => inertia('app/Home'))->name('home');
});
