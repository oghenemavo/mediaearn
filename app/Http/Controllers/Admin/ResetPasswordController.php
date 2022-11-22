<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Forgot Password';
        return view('admin.auth.forgot');
    }

    public function forgot(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email'
        ]);

        $credentials = $request->only('email');
        $status = Password::broker('admins')->sendResetLink($credentials);

        return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
    }
    
    public function showReset(Request $request, $token)
    {
        $data['page_title'] = 'Reset Password';
        $data['token'] = $token;
        $data['email'] = json_decode(urldecode($request->get('via')))[0]->email;
        return view('admin.auth.reset', $data);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
     
        $status = Password::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('admin.login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
