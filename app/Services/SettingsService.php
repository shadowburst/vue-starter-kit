<?php

namespace App\Services;

use App\Actions\Settings\Account\DeleteAccount;
use App\Actions\Settings\Account\UpdateAccountSettings;
use App\Actions\Settings\Password\UpdatePasswordSettings;

class SettingsService
{
    public function __construct(
        public UpdateAccountSettings $updateAccount,
        public DeleteAccount $deleteAccount,
        public UpdatePasswordSettings $updatePassword,
    ) {}
}
