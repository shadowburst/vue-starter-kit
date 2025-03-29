<?php

namespace App\Actions\Settings\Profile;

use Illuminate\Support\Facades\Auth;
use Spatie\QueueableAction\QueueableAction;

class DeleteProfile
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
