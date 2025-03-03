<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use Spatie\QueueableAction\QueueableAction;

class Logout
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
        Auth::guard('web')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return true;
    }
}
