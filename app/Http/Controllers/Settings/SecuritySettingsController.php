<?php

namespace App\Http\Controllers\Settings;

use App\Data\Settings\Security\EditSecuritySettingsProps;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class SecuritySettingsController extends Controller
{
    public function edit()
    {
        return Inertia::render('settings/Security', EditSecuritySettingsProps::from([]));
    }
}
