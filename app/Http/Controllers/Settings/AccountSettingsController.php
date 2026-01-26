<?php

namespace App\Http\Controllers\Settings;

use App\Actions\Settings\Account\DeleteAccount;
use App\Actions\Settings\Account\UpdateAccountSettings;
use App\Data\Auth\ConfirmPassword\ConfirmPasswordRequest;
use App\Data\Settings\Account\UpdateAccountSettingsRequest;
use App\Http\Controllers\Controller;
use App\Support\Toast;
use Inertia\Inertia;

class AccountSettingsController extends Controller
{
    public function edit()
    {
        return Inertia::render('settings/Account', []);
    }

    public function update(UpdateAccountSettingsRequest $data)
    {
        $success = app(UpdateAccountSettings::class)->execute($data);

        if (! $success) {
            Toast::error(__('messages.error'));

            return back();
        }

        Toast::success(__('messages.settings.account.update.success'));

        return to_action([AccountSettingsController::class, 'edit']);
    }

    public function destroy(ConfirmPasswordRequest $data)
    {
        $success = app(DeleteAccount::class)->execute();

        if (! $success) {
            Toast::error(__('messages.error'));

            return back();
        }

        Toast::success(__('messages.settings.account.delete.success'));

        return to_action([AccountSettingsController::class, 'edit']);
    }
}
