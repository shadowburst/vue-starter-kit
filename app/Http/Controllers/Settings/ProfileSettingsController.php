<?php

namespace App\Http\Controllers\Settings;

use App\Data\Auth\ConfirmPassword\ConfirmPasswordRequest;
use App\Data\Settings\Profile\EditProfileSettingsProps;
use App\Data\Settings\Profile\UpdateProfileSettingsRequest;
use App\Facades\Services;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfileSettingsController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return Inertia::render('settings/Profile', EditProfileSettingsProps::from([
            'mustVerifyEmail' => $user instanceof MustVerifyEmail && ! $user?->email_verified_at,
        ]));
    }

    public function update(UpdateProfileSettingsRequest $data)
    {
        $success = Services::settings()->updateProfile->execute($data);

        Services::toast()->successOrError->execute($success, __('messages.settings.profile.update.success'));

        return to_route('settings.profile.edit');
    }

    public function destroy(ConfirmPasswordRequest $data)
    {
        $success = Services::settings()->deleteProfile->execute();

        Services::toast()->successOrError->execute($success, __('messages.settings.profile.delete.success'));

        return to_route('index');
    }
}
