<?php

namespace App\Services;

use App\Actions\Auth\VerifyEmailCode;
use App\Models\User;
use Illuminate\Contracts\Session\Session;

class AuthService
{
    public function __construct(
        public VerifyEmailCode $verifyEmailCode,
    ) {}

    public function user(): ?User
    {
        return request()->user();
    }

    public function session(): Session
    {
        return request()->session();
    }
}
