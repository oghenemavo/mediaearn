<?php

namespace App\Http\Controllers\Api;

use App\Enums\ReferralTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Plan;
use App\Models\Promotion;
use App\Models\Referral;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function getCategories()
    {
        $category_collection = Category::query()->get();
        return response()->json(['categories' => $category_collection]);
    }

    public function validateUniqueCategory(Request $request)
    {
        $inp_category = $request->get('category');
        $ignore_id = $request->get('ignore_id') ?? null;
        
        $category = new Category();
        $is_valid = ! $category->categoryExists($inp_category, $ignore_id);
        echo json_encode($is_valid);
    }

    public function getVideos()
    {
        $video_collection = Video::query()->get();
        $mapped_videos = $video_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['title'] = $item->title;
            $data['slug'] = $item->slug;
            $data['category'] = $item->category->category;
            $data['description'] = htmlspecialchars_decode($item->description);
            $data['url'] = $item->url;
            $data['video_url'] = $item->video_url;
            $data['cover'] = $item->cover;
            $data['length'] = $item->length;
            $data['charges'] = $item->charges;
            $data['earnable'] = $item->earnable;
            $data['earnable_ns'] = $item->earnable_ns ?? '0.00';
            $data['earned_after'] = $item->earned_after;
            $data['status'] = $item->status;
            $data['created_at'] = $item->created_at;

            return $data;
        });
        return response()->json(['videos' => $mapped_videos]);
    }

    public function getPromotions()
    {
        $promotion_collection = Promotion::query()->get();
        $mapped_promotions = $promotion_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['title'] = $item->title;
            $data['material'] = asset("promotions/$item->material");
            $data['filename'] = $item->material;
            $data['status'] = $item->status;
            $data['expires_at'] = $item->expires_at;
            $data['created_at'] = $item->created_at;

            return $data;
        });
        return response()->json(['promotions' => $mapped_promotions]);
    }

    public function getUsers()
    {
        $users = User::query()->get();
        $mapped_users = $users->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['name'] = $item->first_name . ' ' . $item->last_name;
            $data['email'] = $item->email;
            $data['bank_code'] = $item->bank_code;
            $data['bank_account'] = $item->bank_account;
            $data['balance'] = $item->wallet->balance ?? '0.00';
            $data['email_verified_at'] = $item->email_verified_at ? true : false;
            $data['referred_by'] = $item->referred_by;
            $data['status'] = $item->status;
            $data['created_at'] = $item->created_at;

            $split = explode(' ', $data['name']);
            $data['initials'] =  isset($split[1]) 
            ? strtoupper($split[0][0]) . strtoupper($split[1][0])
            : strtoupper($split[0][0]) . strtoupper($split[0][1]);

            return $data;
        });
        return response()->json(['users' => $mapped_users]);
    }

    public function getReferrals()
    {
        $referral_collection = Referral::query()->get()->where('referral_type', ReferralTypeEnum::SIGNUP);
        $mapped_referrals = $referral_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['referrer'] = $item->referrer->name;
            $data['referred'] = $item->referred->name;
            $data['bonus'] = $item->bonus;
            $data['referral_type'] = $item->referral_type;
            // $data['tax'] = $item->tax;
            $data['amount'] = $item->amount;
            $data['status'] = $item->status;
            $data['bonus_at'] = $item->bonus_at;
            $data['credited_at'] = $item->credited_at;
            $data['created_at'] = $item->created_at;

            return $data;
        });
        return response()->json(['referrals' => $mapped_referrals]);
    }

    public function getPlans()
    {
        $plan_collection = Plan::query()->get();
        $mapped_plans = $plan_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['title'] = $item->title;
            $data['price'] = $item->price;
            $data['description'] = $item->description;
            $data['set_discount'] = (bool) $item->meta->get('set_discount');
            $data['discount'] = (float) $item->meta->get('discount');
            $data['status'] = $item->status;
            $data['created_at'] = $item->created_at;

            return $data;
        });
        return response()->json(['plans' => $mapped_plans]);
    }
}
