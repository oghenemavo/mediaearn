<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;

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
    
}
