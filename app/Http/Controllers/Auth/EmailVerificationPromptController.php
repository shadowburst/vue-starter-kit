<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;

class EmailVerificationPromptController extends Controller
{
    public function __construct(
        protected AuthService $authService,
    ) {}

    /**
     * Show the email verification prompt page.
     */
    public function __invoke()
    {
        $user = $this->authService->user();

        if ($user?->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        return inertia('auth/VerifyEmail', [
            'status' => $this->authService->session()->get('status'),
        ]);
    }
}
