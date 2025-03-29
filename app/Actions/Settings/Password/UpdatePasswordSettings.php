<?php

namespace App\Actions\Settings\Password;

use App\Data\Settings\Password\UpdatePasswordSettingsRequest;
use App\Models\User;
use Hash;
use Spatie\QueueableAction\QueueableAction;

class UpdatePasswordSettings
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
    public function execute(User $user, UpdatePasswordSettingsRequest $data): bool
    {
        return $user->update([
            'password' => Hash::make($data->password),
        ]);
    }
}
