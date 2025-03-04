<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Support\Facades\Route;

class AuthenticatedSessionController extends Controller
{
    public function __construct(
        protected AuthService $authService,
    ) {}

    /**
     * Show the login page.
     */
    public function create()
    {
        return inertia('auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status'           => $this->authService->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $data)
    {
        $this->authService->login->execute($data);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy()
    {
        $this->authService->logout->execute();

        return to_route('home');
    }
}
