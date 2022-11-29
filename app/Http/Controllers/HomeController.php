<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function pricing(Request $request)
    {
        $data['page_title'] = 'Pricing';
        $data['pricing'] = Plan::query()->get();
        $user = auth('web')->user();
        $data['preferences'] = base64_encode(json_encode([
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->first_name  . ' ' . $user->last_name,
        ]));
        if ($request->has('ref')) {
            $transaction = Transaction::query()->where('tx_ref', $request->query('ref'))->get();
            if ($transaction) {
                session()->flash('payment_status', $transaction->first()->status);
            }
         }
        return view('user.pricing', $data);
    }
}
