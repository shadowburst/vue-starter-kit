<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;

class RegisteredUserController extends Controller
{
    public function __construct(
        protected AuthService $authService,
    ) {}

    /**
     * Show the registration page.
     */
    public function create()
    {
        return inertia('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $data)
    {
        $this->authService->register->execute($data);

        return to_route('dashboard');
    }
}
