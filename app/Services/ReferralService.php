<?php

namespace App\Services;

use App\Enums\ReferralTypeEnum;
use App\Models\AppSetting;
use App\Models\Referral;
use App\Models\User;
use Carbon\Carbon;

class ReferralService
{
    public function __construct(Referral $referral)
    {
        $this->referral = $referral;
    }

    public function setReferral($user_id, $referral_code)
    {
        $referrer = User::where('referral_code', $referral_code)->first();
        if ($referrer) {
            $bonus_value = 0;
            $bonusType = AppSetting::query()->where('slug', 'referral_bonus_type')->first()->value;
            $bonus = AppSetting::query()->where('slug', 'referral_bonus')->first()->value;

            if ($bonusType == 'fixed') {
                $bonus_value = $bonus;
            }

            $refer_info = [
                'referrer_user_id' => $referrer->id,
                'referred_user_id' => $user_id,
                'referral_type' => ReferralTypeEnum::SIGNUP,
                'amount' => $bonus_value,
                'meta' => [
                    'bonus_type' => $bonusType,
                    'bonus' => $bonus,
                ],
                'status' => '1',
                'bonus_at' => Carbon::now()
            ];
            return $this->referral->create($refer_info);
        }
        return false;
    }

    public function setVideoReferralBonus($referrerUserId, $userId, $videoId)
    {
        $data = [
            'referrer_user_id' => $referrerUserId,
            'referred_user_id' => $userId,
            'referral_type' => ReferralTypeEnum::VIDEO,
            'amount' => 12,
            'status' => '1',
            'meta' => [
                'video_id' => $videoId
            ]
        ];

        return $this->referral->where('referred_user_id', 2)
            ->whereJsonContains('meta->video_id', $videoId)
            ->firstOr(function () use($data) {

            return $this->referral->create($data);
        });
    }

    public function setVideoDownlineBonus($referrerUserId, $userId, $videoId, $amount)
    {
        if ($amount > 0.00001) {
            $data = [
                'referrer_user_id' => $referrerUserId,
                'referred_user_id' => $userId,
                'referral_type' => ReferralTypeEnum::VIDEO,
                'amount' => $amount,
                'status' => '2',
                'meta' => [
                    'video_id' => $videoId
                ]
            ];
    
            $user = User::find($referrerUserId);
            $user->wallet->balance += $amount;
            $user->wallet->save();
        }

        return $this->referral->create($data);
    }
    
}