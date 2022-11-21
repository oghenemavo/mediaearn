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
    
}