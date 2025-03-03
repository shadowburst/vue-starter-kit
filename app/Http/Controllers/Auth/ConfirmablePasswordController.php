<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ConfirmPasswordRequest;
use App\Services\AuthService;

class ConfirmablePasswordController extends Controller
{
    public function __construct(
        protected AuthService $authService,
    ) {}

    /**
     * Show the confirm password page.
     */
    public function show()
    {
        return inertia('auth/ConfirmPassword');
    }

    /**
     * Confirm the user's password.
     */
    public function store(ConfirmPasswordRequest $data)
    {
        $this->authService->confirmPassword->execute($data);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
