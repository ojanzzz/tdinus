<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'serviceCount' => Service::count(),
            'newsCount' => News::count(),
        ]);
    }
}
