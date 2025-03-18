<?php

namespace App\Services;

use App\Actions\Auth\VerifyCode;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(
        public VerifyCode $verifyCode,
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
