<?php

namespace App\Services;

use App\Enums\ReferralTypeEnum;
use App\Models\Referral;
use App\Models\User;

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
            $refer_info = [
                'referrer_user_id' => $referrer->id,
                'referred_user_id' => $user_id,
                'referral_type' => ReferralTypeEnum::SIGNUP,
                'status' => '0'
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
    
}