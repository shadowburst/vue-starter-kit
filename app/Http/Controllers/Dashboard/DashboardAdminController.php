<?php

namespace App\Http\Controllers\Dashboard;

use App\Data\Dashboard\Admin\Index\DashboardAdminIndexProps;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DashboardAdminController extends Controller
{
    public function index()
    {
        return Inertia::render('dashboard/admin/Index', DashboardAdminIndexProps::from([]));
    }
}
