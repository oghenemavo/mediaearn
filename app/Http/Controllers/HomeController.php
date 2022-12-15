<?php

namespace App\Http\Controllers;

use App\Contracts\IUser;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Plan;
use App\Models\Promotion;
use App\Models\Transaction;
use App\Models\Video;
use Illuminate\Support\Str;
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
        $carousel = Video::query()->where('status', '1')->orderby('id', 'desc')->limit(5)->get();
        $videos = Video::query()->where('status', '1')->orderby('id', 'desc')->get();
        $promotions = Promotion::query()->where('status', '1')->inRandomOrder()->get();

        $data['carousel'] = $carousel;
        $data['posts'] = $videos;
        $data['promotions'] = $promotions;
        return view('welcome', $data);
    }

    public function pricing(Request $request)
    {
        $data['page_title'] = 'Pricing';
        $data['pricing'] = Plan::query()->where('status', '1')->get();
        $data['subscription'] = false;
        $user = auth('web')->user();
        $data['balance'] = $user->wallet->balance;
        
        $membership = $this->userRepository->getMembership($user->id);
        $data['subscription'] = $membership?->count() ?? false;
        if ($data['subscription']) {
            $data['membership'] = $membership;
        }
        
        $data['preferences'] = base64_encode(json_encode([
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->first_name  . ' ' . $user->last_name,
        ]));
        if ($request->has('ref')) {
            $transaction = Transaction::query()->where('tx_ref', $request->query('ref'))->get();
            if ($transaction) {
                session()->flash('info', $transaction->first()->status);
            }
         }
        return view('user.pricing', $data);
    }

    public function category(Category $category)
    {
        $data['page_title'] = $category->category;
        $data['category'] = $category;

        $videos = $category->videos()->where('status', '1')->get();
        $promotions = Promotion::query()->where('status', '1')->inRandomOrder()->get();
        $mapped_videos = $videos->map(function($item, $key) {
            $post['id'] = $item->id;
            $post['type'] = 'post';
            $post['cover'] = $item->cover;
            $post['slug'] = $item->slug;
            $post['title'] = $item->title;
            $post['category'] = $item->category;

            return $post;
        });
        $mapped_promotions = $promotions->map(function($item, $key) {
            
            $post['type'] = 'ads';
            $ext = Str::substr($item->material, -3);
            $imageExtensions = ['jpeg','png','jpg','gif','svg',];
            $post['ads_type'] = in_array($ext, $imageExtensions) ? 'image' : 'video';
            $post['cover'] = $item->material;
            // $post['slug'] = $item->slug;
            $post['title'] = $item->title;

            return $post;
        });

        $data['posts'] = $videos;
        $data['promotions'] = $promotions;
        $data['sponsored'] = $mapped_promotions->slice(0, 6);
        
        return view('category', $data);
    }

    public function faq()
    {
        $data['page_title'] = 'Frequently Asked Questions';
        $faqs = Faq::query()->get();
        $count = ceil($faqs->count()/2);
        $data['faq1'] = $faqs->slice(0, $count);
        $data['faq2']= $faqs->slice($count);
        
        return view('faq', $data);
    }
}
