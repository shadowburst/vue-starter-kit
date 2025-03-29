<?php

namespace App\Actions\Settings\Profile;

use App\Data\Settings\Profile\UpdateProfileSettingsRequest;
use App\Models\User;
use Spatie\QueueableAction\QueueableAction;

class UpdateProfileSettings
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
    public function execute(User $user, UpdateProfileSettingsRequest $data): bool
    {
        $user->fill($data->toArray());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        return $user->save();
    }
}
