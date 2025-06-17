<?php

namespace App\Http\Controllers\Settings;

use App\Data\Auth\ConfirmPassword\ConfirmPasswordRequest;
use App\Data\Settings\Profile\EditProfileSettingsProps;
use App\Data\Settings\Profile\UpdateProfileSettingsRequest;
use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use App\Services\ToastService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfileSettingsController extends Controller
{
    public function __construct(
        protected SettingsService $settingsService,
        protected ToastService $toastService,
    ) {}

    /**
     * Show the user's profile settings page.
     */
    public function edit()
    {
        $user = Auth::user();

        return Inertia::render('settings/Profile', EditProfileSettingsProps::from([
            'mustVerifyEmail' => $user instanceof MustVerifyEmail && ! $user?->email_verified_at,
        ]));
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateProfileSettingsRequest $data)
    {
        $success = $this->settingsService->updateProfile->execute($data);

        $this->toastService->successOrError->execute($success, __('messages.settings.profile.update.success'));

        return to_route('settings.profile.edit');
    }

    /**
     * Delete the user's profile.
     */
    public function destroy(ConfirmPasswordRequest $data)
    {
        $success = $this->settingsService->deleteProfile->execute();

        $this->toastService->successOrError->execute($success, __('messages.settings.profile.delete.success'));

        return to_route('index');
    }
}
