<?php

namespace App\Http\Controllers\Settings;

use App\Data\Auth\ConfirmPassword\ConfirmPasswordRequest;
use App\Data\Settings\Profile\EditProfileSettingsProps;
use App\Data\Settings\Profile\UpdateProfileSettingsRequest;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\SettingsService;
use App\Services\ToastService;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class ProfileSettingsController extends Controller
{
    public function __construct(
        protected AuthService $authService,
        protected SettingsService $settingsService,
        protected ToastService $toastService,
    ) {}

    /**
     * Show the user's profile settings page.
     */
    public function edit()
    {
        $user = $this->authService->user();

        return inertia('settings/Profile', EditProfileSettingsProps::from([
            'mustVerifyEmail' => $user instanceof MustVerifyEmail && ! $user?->email_verified_at,
        ]));
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateProfileSettingsRequest $data)
    {
        $success = $this->settingsService->updateProfile->execute(
            $this->authService->user(),
            $data,
        );

        if ($success) {
            $this->toastService->success->execute(__('messages.settings.profile.update.success'));
        } else {
            $this->toastService->error->execute(__('messages.error'));
        }

        return to_route('settings.profile.edit');
    }

    /**
     * Delete the user's profile.
     */
    public function destroy(ConfirmPasswordRequest $data)
    {
        $success = $this->settingsService->deleteProfile->execute();

        if ($success) {
            $this->toastService->success->execute(__('messages.settings.profile.delete.success'));
        } else {
            $this->toastService->error->execute(__('messages.error'));
        }

        return to_route('index');
    }
}
