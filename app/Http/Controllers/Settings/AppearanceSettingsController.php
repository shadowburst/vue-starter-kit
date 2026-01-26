<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class AppearanceSettingsController extends Controller
{
    public function edit()
    {
        return Inertia::render('settings/Appearance', []);
    }
}
