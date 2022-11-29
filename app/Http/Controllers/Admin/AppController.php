<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AppController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Admin Settings';
        $data['app_settings'] = AppSetting::query()->get();
        return view('admin.dashboard.app-settings', $data);
    }

    public function edit(Request $request, AppSetting $settings)
    {
        $request->validate([
            'settings_value' => 'required',
        ]);
        
        $settings->value = $request->settings_value;

        $result = $settings->save();
        if ($result) {
            return response()->json(['success' => true]);
        }
        return response()->json(['fail' => true]);
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->guard('admin')->user();
        
        $attributes = [
            'current' => 'Current Password',
            'new_password' => 'New Password',
        ];
        $request->validate([
            'current_password' => 'required|string|current_password:admin',
            'password' => 'required|confirmed|min:6|string'
        ], [], $attributes);
        
        $user->password = $request->password;
        $result = $user->save();
        if ($result) {
            return back()->with('primary', 'Password Updated Successfully!');
        }
        return back()->with('danger', 'Unable to Update Password!');
    }
    
    public function emailPassword(Request $request)
    {
        $user = auth()->guard('admin')->user();
        $rules = [
            'email' => [
                'required',
                'email',
                Rule::unique('admins')->ignore($user->id)
            ],
        ];

        $request->validate($rules);
        
        $user->email = $request->email;
        $user->save();

        if ($user->isDirty()) {
            return back()->with('success', 'Account Email changed successfully!');
        }
        return back()->with('info', 'No changes made!');
    }

    public function plans()
    {
        $data['page_title'] = 'View & Setup Subscription Plans';
        $data['app_settings'] = AppSetting::query()->get();
        return view('admin.dashboard.app-settings', $data);
    }
    
}
