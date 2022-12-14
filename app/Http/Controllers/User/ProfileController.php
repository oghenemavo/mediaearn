<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FlutterWaveService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct(protected FlutterWaveService $flwService)
    {
        $this->flwService = $flwService;
    }

    public function index()
    {
        $data['page_title'] = 'Profile';
        $data['user'] = $user = auth()->guard('web')->user();
        $data['banks'] = $this->flwService->fetchBanks();
        // $data['banks'] = [ 
        //     'data' => [
        //         0 => [
        //             "id" => 044,
        //             "code" => "560",
        //             "name" => "Page MFBank"
        //         ],
        //         1 => [
        //             "id" => 133,
        //             "code" => "304",
        //             "name" => "Stanbic Mobile Money"
        //         ],
        //         2 => [
        //             "id" => 134,
        //             "code" => "308",
        //             "name" => "FortisMobile"
        //         ]
        //     ],
        // ];
        
        $bank = function($array, $user) {
            return array_filter($array, function($arr) use($user) {
                if ($arr['code'] == $user->bank_code) {
                    return true;
                }
                return false;
            });
        };
        if (!empty($user->bank_code)) {
            $bankName = $bank($data['banks']['data'], $user);
            $data['bank'] = reset($bankName)['name'];
        } else {
            $data['bank'] = 'Bank Name';
        }

        return view('user.profile', $data);
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string|current_password:web',
            'password' => 'required|confirmed|min:6|string'
        ]);

        $user = auth()->guard('web')->user();
        $user->password = $request->password;

        $result = $user->save();
        if ($result) {
            return back()->with('primary', 'Password Updated Successfully!');
        }
        return back()->with('danger', 'Unable to Update Password!');
    }

    public function email(Request $request)
    {
        $user = auth()->guard('web')->user();
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
        ]);

        $user->email = $request->email;
        $result = $user->save();
        if ($result) {
            return back()->with('primary', 'Email Updated Successfully!');
        }
        return back()->with('danger', 'Unable to Update Email!');
    }

    public function accountInfo(Request $request)
    {
        $request->validate([
            'bank' => 'required',
            'account_number' => 'required',
        ]);
        
        $user = auth()->guard('web')->user();
        $user->bank_code = $request->bank;
        $user->account_number = $request->account_number;
        $result = $user->save();
        if ($result) {
            return back()->with('primary', 'Account Details Updated Successfully!');
        }
        return back()->with('danger', 'Unable to Update Account Details!');
    }
}
