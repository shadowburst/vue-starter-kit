<?php

namespace App\Http\Controllers\Settings;

use App\Data\Auth\ConfirmPassword\ConfirmPasswordRequest;
use App\Data\Settings\Account\EditAccountSettingsProps;
use App\Data\Settings\Account\UpdateAccountSettingsRequest;
use App\Facades\Services;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class AccountSettingsController extends Controller
{
    public function edit()
    {
        return Inertia::render('settings/Account', EditAccountSettingsProps::from([]));
    }

    public function update(UpdateAccountSettingsRequest $data)
    {
        $success = Services::settings()->updateAccount->execute($data);

        Services::toast()->successOrError->execute($success, __('messages.settings.account.update.success'));

        return to_route('settings.account.edit');
    }

    public function destroy(ConfirmPasswordRequest $data)
    {
        $success = Services::settings()->deleteAccount->execute();

        Services::toast()->successOrError->execute($success, __('messages.settings.account.delete.success'));

        return to_route('index');
    }
}
