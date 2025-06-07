<?php

namespace App\Http\Controllers\Settings;

use App\Data\Settings\Security\EditSecuritySettingsProps;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class SecuritySettingsController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit()
    {
        return Inertia::render('settings/Security', EditSecuritySettingsProps::from([]));
    }
}
