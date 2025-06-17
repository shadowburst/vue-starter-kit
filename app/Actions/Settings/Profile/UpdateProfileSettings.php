<?php

namespace App\Actions\Settings\Profile;

use App\Data\Settings\Profile\UpdateProfileSettingsRequest;
use App\Facades\Services;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\QueueableAction\QueueableAction;

class UpdateProfileSettings
{
    use QueueableAction;

    public function __construct(
        //
    ) {}

    public function execute(UpdateProfileSettingsRequest $data): bool
    {
        DB::beginTransaction();

        $user = $data->user;

        $user->fill($data->toArray());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
        }

        $success = Services::media()->update->execute($user, User::COLLECTION_AVATAR, $data->avatar) && $user->save();

        if (! $success) {
            DB::rollBack();

            return false;
        }

        DB::commit();

        return true;
    }
}
