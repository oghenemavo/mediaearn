<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Admin Dashboard Area';
        $data['total_users'] = User::get()->count();
        $data['total_videos'] = Video::get()->count() ?? 0;
        $data['active_videos'] = Video::where('status', '1')->get()->count() ?? 0;
        $data['subscriptions'] = Membership::query()->get()->count() ?? 0;
        return view('admin.dashboard.index', $data);
    }

    public function showUsers()
    {
        $data['page_title'] = 'App users';
        return view('admin.dashboard.users', $data);
    }

    public function activateUser(User $user)
    {
        $user->status = UserStatusEnum::ACTIVE;

        $result = $user->save();
        if ($result) {
            return response()->json(['success' => true]);
        }
        return response()->json(['fail' => true]);
    }

    public function suspendUser(User $user)
    {
        $user->status = UserStatusEnum::INACTIVE;

        $result = $user->save();
        if ($result) {
            return response()->json(['success' => true]);
        }
        return response()->json(['fail' => true]);
    }
}
