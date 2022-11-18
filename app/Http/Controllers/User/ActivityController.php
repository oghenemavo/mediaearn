<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function video()
    {
        $data['page_title'] = 'Forgot Password';
        return view('user.video', $data);
    }
}
