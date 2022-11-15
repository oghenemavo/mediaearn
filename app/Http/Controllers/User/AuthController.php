<?php

namespace App\Http\Controllers\User;

use App\Enums\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Http\Request;

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
}
