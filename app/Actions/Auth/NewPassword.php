<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\NewPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

class NewPassword
{
    use QueueableAction;

    /**
     * Create a new action instance.
     */
    public function __construct(
        //
    ) {}

    /**
     * Execute the action.
     */
    public function execute(NewPasswordRequest $data): string
    {
        $status = Password::reset(
            $data->toArray(),
            function ($user) use ($data) {
                $user->forceFill([
                    'password'       => Hash::make($data->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            },
        );

        return $status;
    }
}
