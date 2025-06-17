<?php

namespace App\Actions\Settings\Password;

use App\Data\Settings\Password\UpdatePasswordSettingsRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\QueueableAction\QueueableAction;

class UpdatePasswordSettings
{
    use QueueableAction;

    public function __construct(
        //
    ) {}

    public function execute(UpdatePasswordSettingsRequest $data): bool
    {
        return $data->user->update([
            'password' => Hash::make($data->password),
        ]);
    }
}
