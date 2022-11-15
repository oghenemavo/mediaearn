<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;

class AuthController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Sign up';
        return view('auth.signup', $data);
    }

    public function create(UserCreateRequest $request)
    {
        $data = $request->validated();
        $data['status'] = UserStatusEnum::INACTIVE;

        $user = User::create($data);

        if ($user) {
            return redirect()->route('homepage');
            // return redirect()->back()->withInput()->with('error', 'unable to signup user, try again!');
        }
        return redirect()->back()->withInput()->with('error', 'unable to signup user, try again!');
    }

    public function login()
    {
        $data['page_title'] = 'Login up';
        return view('auth.login', $data);
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:5'
        ]);

        $credentials = $request->except(['_token']);
        // $credentials['status'] = UserStatusEnum::ACTIVE;

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        } else {
            return redirect()->back()->onlyInput('email')->with('error', 'Invalid credentials');
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        auth()->logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }

}
