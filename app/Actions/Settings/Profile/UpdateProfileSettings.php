<?php

namespace App\Actions\Settings\Profile;

use App\Data\Settings\Profile\UpdateProfileSettingsRequest;
use App\Models\User;
use App\Services\MediaService;
use Spatie\QueueableAction\QueueableAction;

class UpdateProfileSettings
{
    use QueueableAction;

    /**
     * Create a new action instance.
     */
    public function __construct(
        protected MediaService $mediaService,
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

        if (! $this->mediaService->updateOne->execute($user, User::COLLECTION_AVATAR, $data->avatar)) {
            return false;
        }

        return $user->save();
    }
}
