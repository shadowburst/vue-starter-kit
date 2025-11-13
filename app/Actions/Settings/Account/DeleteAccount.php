<?php

namespace App\Actions\Settings\Account;

use Illuminate\Support\Facades\Auth;
use Spatie\QueueableAction\QueueableAction;

class DeleteAccount
{
    use QueueableAction;

    public function __construct(
        //
    ) {}

    public function execute(): bool
    {
        $request = request();

        /** @var \App\Models\User $user */
        $user = request()->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return true;
    }
}
