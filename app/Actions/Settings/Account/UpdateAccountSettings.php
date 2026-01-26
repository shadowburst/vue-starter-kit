<?php

namespace App\Actions\Settings\Account;

use App\Actions\Media\UpdateMedia;
use App\Data\Settings\Account\UpdateAccountSettingsRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\QueueableAction\QueueableAction;

class UpdateAccountSettings
{
    use QueueableAction;

    public function __construct(
        //
    ) {}

    public function execute(UpdateAccountSettingsRequest $data): bool
    {
        DB::beginTransaction();

        $user = $data->user;

        $user->fill($data->toArray());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
        }

        $success = app(UpdateMedia::class)->execute($user, User::COLLECTION_AVATAR, $data->avatar) && $user->save();

        if (! $success) {
            DB::rollBack();

            return false;
        }

        DB::commit();

        return true;
    }
}
