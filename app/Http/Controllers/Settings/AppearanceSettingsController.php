<?php

namespace App\Http\Controllers\Settings;

use App\Data\Settings\Appearance\EditAppearanceSettingsProps;
use App\Http\Controllers\Controller;

class AppearanceSettingsController extends Controller
{
    public function edit()
    {
        return inertia('settings/Appearance', EditAppearanceSettingsProps::from([]));
    }
}
