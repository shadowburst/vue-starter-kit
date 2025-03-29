<?php

namespace App\Http\Controllers\Settings;

use App\Data\Settings\Password\UpdatePasswordSettingsRequest;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\SettingsService;
use App\Services\ToastService;

class PasswordSettingsController extends Controller
{
    public function __construct(
        protected AuthService $authService,
        protected SettingsService $settingsService,
        protected ToastService $toastService,
    ) {}

    /**
     * Update the user's password.
     */
    public function update(UpdatePasswordSettingsRequest $data)
    {
        $success = $this->settingsService->updatePassword->execute(
            $this->authService->user(),
            $data,
        );

        if ($success) {
            $this->toastService->success->execute(__('messages.settings.password.update.success'));
        } else {
            $this->toastService->error->execute(__('messages.error'));
        }

        return back();
    }
}
