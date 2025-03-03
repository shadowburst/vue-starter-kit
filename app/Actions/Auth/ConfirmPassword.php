<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\ConfirmPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Spatie\QueueableAction\QueueableAction;

class ConfirmPassword
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
    public function execute(ConfirmPasswordRequest $data): bool
    {
        $success = Auth::guard('web')->validate([
            'email'    => request()->user()->email,
            'password' => $data->password,
        ]);

        throw_if(
            ! $success,
            ValidationException::withMessages([
                'password' => __('auth.password'),
            ]),
        );

        request()->session()->put('auth.password_confirmed_at', time());

        return true;

    }
}
