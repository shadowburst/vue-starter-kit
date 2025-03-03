<?php

namespace App\Services;

use App\Actions\Auth\ConfirmPassword;
use App\Actions\Auth\Login;
use App\Actions\Auth\Logout;
use App\Actions\Auth\NewPassword;
use App\Actions\Auth\Register;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(
        public Login $login,
        public Logout $logout,
        public Register $register,
        public NewPassword $newPassword,
        public ConfirmPassword $confirmPassword,
    ) {}

    public function user(): ?User
    {
        return Auth::user();
    }

    public function session(): Session
    {
        return request()->session();
    }
}
