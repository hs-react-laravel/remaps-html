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
        $user = $this->user;
        if ($this->role == 'company' || $this->role == 'master') {
            $data['orders'] = \App\Models\Order::whereHas('user', function($query) use($user){
                $query->where('company_id', $user->company_id);
            })->orderBy('id', 'DESC')->take(5)->get();
            $data['fs_pending'] = \App\Models\FileService::whereHas('user', function($query) use($user){
                $query->where('company_id', $user->company_id);
            })->where('status', 'P')->count();
            $data['fs_open'] = \App\Models\FileService::whereHas('user', function($query) use($user){
                $query->where('company_id', $user->company_id);
            })->where('status', 'O')->count();
            $data['fs_waiting'] = \App\Models\FileService::whereHas('user', function($query) use($user){
                $query->where('company_id', $user->company_id);
            })->where('status', 'W')->count();
            $data['fs_completed'] = \App\Models\FileService::whereHas('user', function($query) use($user){
                $query->where('company_id', $user->company_id);
            })->where('status', 'C')->count();
            return view('pages.dashboard.admin', compact('data'));
        }
        return view('pages.dashboard.consumer');
    }
}
