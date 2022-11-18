<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function password()
    {
        $data['page_title'] = 'Forgot Password';
        return view('user.password', $data);
    }

    public function changePwd(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string|current_password',
            'password' => 'required|confirmed|min:6|string'
        ]);

        auth()->user()->password = $request->password;
        
        $result = auth()->user()->save();
        if ($result) {
            return back()->with('primary', 'Password Updated Successfully!');
        }
        return back()->with('danger', 'Unable to Update Password!');
    }

    public function changeEmail(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
        ]);

        auth()->user()->email = $request->email;

        $result = auth()->user()->save();
        if ($result) {
            return back()->with('primary', 'Email Updated Successfully!');
        }
        return back()->with('danger', 'Unable to Update Email!');
    }
}
