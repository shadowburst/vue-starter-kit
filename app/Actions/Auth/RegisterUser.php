<?php

namespace App\Actions\Auth;

use App\Data\Auth\Register\RegisterRequest;
use App\Enums\Role\RoleName;
use App\Facades\Services;
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

        $team = Services::team()->createDefault->execute();

        /** @var User $user */
        $user = User::create([
            ...$data->except('password', 'password_confirmation')->toArray(),
            'team_id'  => $team->id,
            'password' => Hash::make($data->password),
        ]);

        $user->assignRole(RoleName::OWNER, RoleName::EDITOR);

        return $user;
    }
}
