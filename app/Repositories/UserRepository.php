<?php

namespace App\Repositories;

use App\Contracts\IUser;
use App\Enums\UserStatusEnum;
use App\Models\AppSetting;
use App\Models\Membership;
use App\Models\Referral;
use App\Models\User;
use App\Services\ReferralService;
use App\Services\WalletService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserRepository implements IUser
{
    public function __construct(
        protected User $user,
        protected ReferralService $referral,
        protected WalletService $wallet,
        protected Membership $membership,
    )
    {
        $this->user = $user;
        $this->referral = $referral;
        $this->wallet = $wallet;
    }

    public function createUser($attributes)
    {
        return DB::transaction(function() use($attributes) {
            // create user account
            $user = $this->user->create([
                'first_name' => data_get($attributes, 'first_name'),
                'last_name' => data_get($attributes, 'last_name'),
                'email' => data_get($attributes, 'email'),
                'password' => data_get($attributes, 'password'),
                'referral_code' => uniqid(substr(data_get($attributes, 'email'), 0, 3)),
                'status' => UserStatusEnum::ACTIVE,
            ]);
    
            // create referral record
            $referrer_code = data_get($attributes, 'referral_id');
            if ($referrer_code) {
                $this->referral->setReferral($user->id, $referrer_code); 
            }
    
            // create wallet
            $this->wallet->createWallet($user->id);

            $signupBonus = AppSetting::where('slug', 'signup_bonus')->first();

            if ($signupBonus && $signupBonus?->value > 0) {
                $user->wallet->balance = $signupBonus->value;
                $user->wallet->save();
            }

            return $user;
        });

        return false;
    }

    public function createMembership($user_id, $tx_ref, $amount, $planId)
    {
        // creates only once
        $membership = $this->membership->create([
            'reference' => $tx_ref, 
            'amount' => $amount, 
            'status' => '1',
            'user_id' => $user_id,
            'plan_id' => $planId,
        ]);

        if ($membership) {
            // check if this user is referred
            $referral_info = Referral::where('referred_user_id', $user_id)->first();
            if ($referral_info && $referral_info->status != '2') {
                $bonus_value = 0;
                $bonusType = AppSetting::query()->where('slug', 'referral_bonus_type')->first()->value;
                $bonus = AppSetting::query()->where('slug', 'referral_bonus')->first()->value;

                $user = $referral_info->referrer;

                if ($bonusType == 'percentage') {
                    $bonus_value = $amount * ($bonus / 100);
                    $referral_info->amount = $bonus_value;
                    $referral_info->bonus_at = Carbon::now();
                    
                    $referral_info->meta = [
                        'bonus_type' => $bonusType,
                        'bonus' => $bonus,
                    ];

                    $user->wallet->balance += $bonus_value;
                    $user->wallet->save();
                } else {
                    // for fixed
                    $user->wallet->balance += $referral_info->amount;
                    $user->wallet->save();
                }

                $referral_info->status = '2';
                $referral_info->save();
            }

            return back()->with('success', 'payment successful, you have subscribed');
        }
        
        // send email
    }

    public function referralVideoReward($user, $videoId, $amount)
    {
        // $referredBy = $user->referral?->referrer_user_id;
        // if ($referredBy) {
        //     return $this->referral->setVideoReferralBonus($referredBy, $user->id, $videoId);
        // }
        // return false;
        $bonusPercent = AppSetting::where('slug', 'downline_bonus')->first()->value;
        return downlineBonusDistribution($user, $videoId, $amount, $bonusPercent, true);
    }

    public function getMembership($userId)
    {
        return $this->membership->query()->where('user_id', $userId)
            ->where('status', '1')
            ->orderby('id', 'desc')
            ->first();
    }

}