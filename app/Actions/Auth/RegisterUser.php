<?php

namespace App\Actions\Auth;

use App\Data\Auth\Register\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class RegisterUser implements CreatesNewUsers
{
    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $data = app(RegisterRequest::class);

        return User::create([
            ...$data->except('password', 'password_confirmation')->toArray(),
            'password' => Hash::make($data->password),
        ]);
    }
}
