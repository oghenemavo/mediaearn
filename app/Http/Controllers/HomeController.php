<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['page_title'] = "Earner's view | Welcome";
        $data['carousel'] = Video::query()->where('status', '1')->orderby('id', 'desc')->limit(5)->get();
        $data['videos'] = Video::query()->where('status', '1')->orderby('id', 'desc')->get();
        return view('welcome', $data);
    }

    public function pricing(Request $request)
    {
        $data['page_title'] = 'Pricing';
        $data['pricing'] = Plan::query()->where('status', '1')->get();
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

    public function category(Category $category)
    {
        $data['page_title'] = $category->category;
        $data['category'] = $category;
        return view('category', $data);
    }
}
