<?php

namespace App\Actions\Settings\Password;

use App\Data\Settings\Password\UpdatePasswordSettingsRequest;
use App\Models\User;
use Hash;
use Spatie\QueueableAction\QueueableAction;

class UpdatePasswordSettings
{
    use QueueableAction;

    public function __construct(
        //
    ) {}

    public function execute(User $user, UpdatePasswordSettingsRequest $data): bool
    {
        return $user->update([
            'password' => Hash::make($data->password),
        ]);
    }
}
