<?php

namespace App\Http\Controllers\Settings;

use App\Data\Settings\Password\UpdatePasswordSettingsRequest;
use App\Facades\Services;
use App\Http\Controllers\Controller;

class PasswordSettingsController extends Controller
{
    public function update(UpdatePasswordSettingsRequest $data)
    {
        $success = Services::settings()->updatePassword->execute($data);

        Services::toast()->successOrError->execute($success, __('messages.settings.password.update.success'));

        return back();
    }
}
