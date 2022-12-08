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
        DB::transaction(function() use($attributes) {
            // create user account
            $user = $this->user->create([
                'first_name' => data_get($attributes, 'first_name'),
                'last_name' => data_get($attributes, 'last_name'),
                'email' => data_get($attributes, 'email'),
                'password' => data_get($attributes, 'password'),
                'referral_code' => uniqid(substr(data_get($attributes, 'email'), 0, 3)),
                'status' => UserStatusEnum::INACTIVE,
            ]);
    
            // create referral record
            $referrer_code = data_get($attributes, 'referral_id');
            if ($referrer_code) {
                $this->referral->setReferral($user->id, $referrer_code); 
            }
    
            // create wallet
            $this->wallet->createWallet($user->id);

            return true;
        });

        return false;
    }

    public function createMembership($user_id, $tx_ref, $amount)
    {
        // creates only once
        $membership = $this->membership->firstOrCreate(
            ['user_id' => $user_id],
            ['reference' => $tx_ref, 'amount' => $amount, 'status' => '1']
        );

        if ($membership) {
            // check if this user is referred
            $referral_info = Referral::where('referred_user_id', $user_id)->first();
            if ($referral_info) {
                $bonus_value = 0;
                $bonusType = AppSetting::query()->where('slug', 'referral_bonus_type')->first()->value;
                $bonus = AppSetting::query()->where('slug', 'referral_bonus')->first()->value;

                if ($bonusType == 'percentage') {
                    $bonus_value = $amount * ($bonus / 100);
                } else {
                    $bonus_value = $bonus;
                }

                $referral_info->meta = [
                    'bonus_type' => $bonusType,
                    'bonus' => $bonus,
                ];
                
                $referral_info->amount = $bonus_value;
                $referral_info->status = '1';
                $referral_info->bonus_at = Carbon::now();
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
        return abc($user, $videoId, $amount, $bonusPercent, true);
    }

    public function getMembership($userId)
    {
        return $this->membership->query()->where('user_id', $userId)
            ->where('status', '1')
            ->orderby('id', 'desc')
            ->first();
    }

}