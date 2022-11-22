<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Admin Dashboard Area';
        $data['total_users'] = 0;
        $data['total_videos'] = 0;
        $data['active_videos'] = 0;
        // $data['total_users'] = User::get()->count();
        // $data['total_videos'] = Video::get()->count() ?? 0;
        // $data['active_videos'] = Video::where('status', '1')->get()->count() ?? 0;
        return view('admin.dashboard.index', $data);
    }
}
