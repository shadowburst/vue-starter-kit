<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;

class EmailVerificationNotificationController extends Controller
{
    public function __construct(
        protected AuthService $authService,
    ) {}

    /**
     * Send a new email verification notification.
     */
    public function store()
    {
        $user = $this->authService->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $user->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
