<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\QueueableAction\QueueableAction;

class Register
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
    public function execute(RegisterRequest $data): bool
    {
        $user = User::create([
            'first_name' => $data->first_name,
            'last_name'  => $data->last_name,
            'email'      => $data->email,
            'password'   => Hash::make($data->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return true;
    }
}
