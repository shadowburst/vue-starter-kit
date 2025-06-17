<?php

namespace App\Http\Controllers\Dashboard;

use App\Data\Dashboard\Index\DashboardIndexProps;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('dashboard/Index', DashboardIndexProps::from([]));
    }
}
