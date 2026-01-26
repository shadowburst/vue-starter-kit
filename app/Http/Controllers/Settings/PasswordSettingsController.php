<?php

namespace App\Http\Controllers\Settings;

use App\Actions\Settings\Password\UpdatePasswordSettings;
use App\Data\Settings\Password\UpdatePasswordSettingsRequest;
use App\Http\Controllers\Controller;
use App\Support\Toast;

class PasswordSettingsController extends Controller
{
    public function update(UpdatePasswordSettingsRequest $data)
    {
        $success = app(UpdatePasswordSettings::class)->execute($data);

        if (! $success) {
            Toast::error(__('messages.error'));

            return back();
        }

        Toast::success(__('messages.settings.password.update.success'));

        return back();
    }
}
