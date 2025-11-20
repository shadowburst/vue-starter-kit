<?php

namespace App\Actions\Auth;

use App\Data\Auth\ResetPassword\ResetPasswordRequest;
use App\Models\User;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    /**
     * Validate and reset the user's forgotten password.
     *
     * @param  array<string, string>  $input
     */
    public function reset(User $user, array $input): void
    {
        $data = app(ResetPasswordRequest::class);

        $user
            ->forceFill(['password' => $data->password])
            ->save();
    }
}
