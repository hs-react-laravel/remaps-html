<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Remaps\Controller;
use App\Models\FileService;

class DashboardController extends Controller
{
    // Dashboard - Ecommerce
    public function dashboardEcommerce()
    {
        return view('pages.dashboard.admin');
    }
}
