<?php

namespace App\Http\Controllers\Settings;

use App\Data\Settings\Security\EditSecuritySettingsProps;
use App\Http\Controllers\Controller;

class SecuritySettingsController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit()
    {
        return inertia('settings/Security', EditSecuritySettingsProps::from([]));
    }
}
