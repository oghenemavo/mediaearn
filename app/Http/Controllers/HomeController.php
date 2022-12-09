<?php

namespace App\Http\Controllers;

use App\Contracts\IUser;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(protected IUser $userRepository)
    {
        $this->userRepository = $userRepository;
    }

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
        $data['subscription'] = false;
        $user = auth('web')->user();
        // $userSubscription = $user->membership;
        // if ($userSubscription) {
        //     $data['subscription'] = $userSubscription;
        // }
        $membership = $this->userRepository->getMembership($user->id);
        $data['subscription'] = $membership?->count() ?? false;
        // dd($userSubscription->plan_id);
        // dd($data['subscription']);
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

    public function faq()
    {
        $data['page_title'] = 'Frequently Asked Questions';
        $faqs = Faq::query()->get();
        $count = ceil($faqs->count()/2);
        $data['faq1'] = $faqs->slice(0, $count);
        $data['faq2']= $faqs->slice($count);
        // dd($faq1);
        return view('faq', $data);
    }
}
