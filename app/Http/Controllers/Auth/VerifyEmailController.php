<?php

namespace App\Http\Controllers\Auth;

use App\Data\Auth\VerifyEmail\VerifyEmailRequest;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use URL;

class VerifyEmailController extends Controller
{
    public function __construct(
        protected AuthService $authService,
    ) {}

    /**
     * Mark the authenticated user's email address as verified.
     */
    public function code(VerifyEmailRequest $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = $this->authService->user();

        if (! $this->authService->verifyEmailCode->execute($user, $request)) {
            throw ValidationException::withMessages([
                'code' => __('auth.verification.code.failed'),
            ]);
        }

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)],
        );

        return redirect($verificationUrl);
    }
}
