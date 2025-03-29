<?php

namespace App\Services;

use App\Actions\Settings\Password\UpdatePasswordSettings;
use App\Actions\Settings\Profile\DeleteProfile;
use App\Actions\Settings\Profile\UpdateProfileSettings;

class SettingsService
{
    public function __construct(
        public UpdateProfileSettings $updateProfile,
        public DeleteProfile $deleteProfile,
        public UpdatePasswordSettings $updatePassword,
    ) {}
}
