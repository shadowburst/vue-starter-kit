<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\NewPasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    public function __construct(
        protected AuthService $authService,
    ) {}

    /**
     * Show the password reset page.
     */
    public function create(Request $request)
    {
        return inertia('auth/ResetPassword', [
            'email' => $request->email,
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(NewPasswordRequest $data)
    {
        $status = $this->authService->newPassword->execute($data);

        throw_if(
            $status != Password::PasswordReset,
            ValidationException::withMessages([
                'email' => [__($status)],
            ]),
        );

        return to_route('login')->with('status', __($status));
    }
}
