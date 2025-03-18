<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyCodeRequest;
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
    public function code(VerifyCodeRequest $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = $this->authService->user();

        if (! $this->authService->verifyCode->execute($user, $request)) {
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
