<?php

namespace App\Http\Controllers\Settings;

use App\Data\Settings\Password\UpdatePasswordSettingsRequest;
use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use App\Services\ToastService;
use Illuminate\Support\Facades\Auth;

class PasswordSettingsController extends Controller
{
    public function __construct(
        protected SettingsService $settingsService,
        protected ToastService $toastService,
    ) {}

    /**
     * Update the user's password.
     */
    public function update(UpdatePasswordSettingsRequest $data)
    {
        $success = $this->settingsService->updatePassword->execute(
            Auth::user(),
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
