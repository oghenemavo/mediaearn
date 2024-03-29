<?php

namespace App\Http\Controllers\Api;

use App\Enums\PaymentStatusEnum;
use App\Enums\ReferralTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Charge;
use App\Models\Faq;
use App\Models\Payout;
use App\Models\Plan;
use App\Models\Promotion;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoViewLog;
use App\Services\FlutterWaveService;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function __construct(protected FlutterWaveService $flwService)
    {
        $this->flwService = $flwService;
    }

    public function getCategories()
    {
        $category_collection = Category::query()->orderBy('id', 'desc')->get();
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
        $video_collection = Video::query()->orderBy('id', 'desc')->get();
        $mapped_videos = $video_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['title'] = $item->title;
            $data['slug'] = $item->slug;
            $data['category'] = $item->category->category;
            $data['description'] = html_entity_decode($item->description);
            $data['url'] = $item->url;
            $data['video_url'] = $item->video_url;
            $data['cover'] = $item->cover;
            $data['length'] = ceil($item->length);
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
        $promotion_collection = Promotion::query()->orderBy('id', 'desc')->get();
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
        $users = User::query()->orderBy('id', 'desc')->get();
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

    public function getAdmins()
    {
        $admins = Admin::query()->get();
        $mapped_admins = $admins->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['name'] = $item->name;
            $data['email'] = $item->email;
            $data['status'] = $item->status;
            $data['role'] = $item->roles()->first()->name;
            $data['created_at'] = $item->created_at;

            $data['initials'] = strtoupper(substr($data['name'], 0, 2));
            return $data;
        });
        return response()->json(['admins' => $mapped_admins]);
    }

    public function getReferrals()
    {
        $referral_collection = Referral::query()->where('referral_type', ReferralTypeEnum::SIGNUP)->orderBy('id', 'desc')->get();
        $mapped_referrals = $referral_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['referrer'] = $item->referrer->email;
            $data['referred'] = $item->referred->email;
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
        $plan_collection = Plan::query()->orderby('id', 'desc')->get();
        $mapped_plans = $plan_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['title'] = $item->title;
            $data['price'] = $item->price;
            $data['description'] = html_entity_decode($item->description);
            $data['set_discount'] = (bool) $item->meta->get('set_discount');
            $data['discount'] = (float) $item->meta->get('discount');
            $data['max_views'] = $item->meta->get('max_views');
            $data['status'] = $item->status;
            $data['created_at'] = $item->created_at;

            return $data;
        });
        return response()->json(['plans' => $mapped_plans]);
    }

    public function validateAccountNumber(Request $request)
    {
        $bankCode = $request->bank_code;
        $accountNumber = $request->account_number;
        return $this->flwService->resolveAccount($bankCode, $accountNumber);
    }

    public function getUserReferrals($userId, $referralType = 'signup')
    {
        $referral_collection = Referral::where('referrer_user_id', $userId)->where('referral_type', $referralType)->orderBy('id', 'desc')->get();
        $mapped_referrals = $referral_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['referred'] = $item->referred->last_name . ' ' . $item->referred->first_name;
            $data['bonus'] = $item->amount;
            $data['status'] = $item->status;
            $data['bonus_at'] = $item->bonus_at;
            $data['credited_at'] = $item->credited_at;
            $data['created_at'] = $item->created_at;

            return $data;
        });
        return response()->json(['referrals' => $mapped_referrals]);
    }

    public function getUserTransactions(User $user)
    {
        $transaction_collection = $user->transactions()->where('status', PaymentStatusEnum::SUCCESS)->orWhere('status', PaymentStatusEnum::FAILED)->orderBy('id', 'desc')->get();
        $payout_collection = $user->payouts()->orderBy('id', 'desc')->get();
        $charges_collection = $user->charges()->where('status', '1')->orderBy('id', 'desc')->get();

        $mapped_charges = $charges_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['type'] = 'Payout Charges';
            $data['amount'] = $item->amount;
            $data['reference'] = $item->payout->reference;
            $data['status'] = 'success';
            $data['confirmed_at'] = $item->updated_at;
            $data['created_at'] = $item->created_at;

            return $data;
        });
        $mapped_payouts = $payout_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['type'] = 'Payout';
            $data['amount'] = $item->amount;
            $data['reference'] = $item->reference;
            $data['status'] = $item->status;
            $data['confirmed_at'] = $item->updated_at;
            $data['created_at'] = $item->created_at;

            return $data;
        });
        $mapped_transactions = $transaction_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['type'] = 'Subscription';
            $data['amount'] = $item->amount;
            $data['reference'] = $item->tx_ref;
            $data['status'] = $item->status;
            $data['confirmed_at'] = $item->confirmed_at;
            $data['created_at'] = $item->created_at;

            return $data;
        });

        $mappedArray = [...$mapped_transactions, ...$mapped_payouts, ...$mapped_charges];
        usort($mappedArray, fn($a, $b) => $b['created_at'] <=> $a['created_at']);
        return response()->json(['transactions' => $mappedArray]);
    }

    public function getUserEarnings($userId)
    {
        $videoLog_collection = VideoViewLog::where('user_id', $userId)->orderBy('id', 'desc')->get();
        $mapped_videoLog = $videoLog_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['video'] = $item->video->title;
            $data['watched'] = number_format((float) $item->watched, 2);
            $data['amount'] = $item->earned_amount ?? 0;
            $data['status'] = $item->is_credited;
            $data['credited_at'] = $item->updated_at > $item->created_at ? $item->updated_at : "n/a";
            $data['created_at'] = $item->created_at;

            return $data;
        });
        return response()->json(['video_logs' => $mapped_videoLog]);
    }

    public function getTransactions()
    {
        $transaction_collection = Transaction::query()->orderBy('id', 'desc')->get();
        $charges_collection = Charge::query()->where('status', '1')->orderBy('id', 'desc')->get();

        $mapped_transactions = $transaction_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['name'] = $item->user?->first_name . ' ' . $item->user?->last_name;
            $data['email'] = $item->user?->email;
            $data['type'] = 'Membership';
            $data['amount'] = $item->amount;
            $data['reference'] = $item->tx_ref;
            $data['status'] = $item->status;
            $data['confirmed_at'] = $item->confirmed_at;
            $data['created_at'] = $item->created_at;

            return $data;
        });
        $mapped_charges = $charges_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['name'] = $item->user?->first_name . ' ' . $item->user?->last_name;
            $data['email'] = $item->user?->email;
            $data['type'] = 'Payout Charges';
            $data['amount'] = $item->amount;
            $data['reference'] = $item->payout?->reference;
            $data['status'] = 'success';
            $data['confirmed_at'] = $item->confirmed_at;
            $data['created_at'] = $item->created_at;

            return $data;
        });
        
        $mappedArray = [...$mapped_transactions, ...$mapped_charges];
        usort($mappedArray, fn($a, $b) => $b['created_at'] <=> $a['created_at']);
        return response()->json(['transactions' => $mappedArray]);
    }

    public function getPayouts()
    {
        $payout_collection = Payout::query()->orderBy('id', 'desc')->get();
        $mapped_payouts = $payout_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['name'] = $item->user->first_name . ' ' . $item->user->last_name;
            $data['receipt'] = $item->receipt_no;
            $data['amount'] = $item->amount;
            $data['reference'] = $item->reference;
            $data['status'] = strtolower($item->status);
            $data['message'] = $item->message;
            $data['is_notified'] = $item->is_notified;
            $data['attempts'] = $item->attempts;
            $data['created_at'] = $item->created_at;

            return $data;
        });
        return response()->json(['payouts' => $mapped_payouts]);
    }

    public function getVideoLogs()
    {
        $videoLog_collection = VideoViewLog::query()->orderBy('id', 'desc')->get();
        $mapped_videoLog = $videoLog_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['name'] = $item->user->first_name . ' ' . $item->user->last_name;
            $data['video'] = $item->video->title;
            $data['watched'] = number_format((float) $item->watched, 2);
            $data['amount'] = $item->earned_amount;
            // $data['tax'] = $item->tax ?? '0.00';
            // $data['credit'] = $item->credit;
            $data['status'] = $item->is_credited;
            $data['credited_at'] = $item->updated_at > $item->created_at ? $item->updated_at : "n/a";
            $data['created_at'] = $item->created_at;

            return $data;
        });
        return response()->json(['video_logs' => $mapped_videoLog]);
    }

    public function getFaqs()
    {
        $faq_collection = Faq::query()->get();
        $mapped_faqs = $faq_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['title'] = $item->title;
            $data['description'] = html_entity_decode($item->description);
            $data['created_at'] = $item->created_at;

            return $data;
        });
        return response()->json(['faqs' => $mapped_faqs]);
    }
}
