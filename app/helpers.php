<?php

use App\Models\AppSetting;
use App\Models\Referral;
use App\Models\User;
use App\Services\ReferralService;

if (! function_exists('clean')) {
  function clean(string $data) 
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES);
    $data = filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH);
    return $data;
  }
}

if (! function_exists('downlineBonusDistribution')) {
  function downlineBonusDistribution(User $user, $videoId, $amount, $bonusPercent, $first = true)
  {
    if (is_null($user->referral)) {
      return true;
    } else {
      // send bonus
      if (!$first) {
        $downlineSharingFactor = AppSetting::where('slug', 'downline_sharing_factor')->first()->value;
        $bonusPercent /= $downlineSharingFactor;
      }
      $amountFinal = ($bonusPercent/100) * $amount;
      
      $referredX = $user->referral;
      $referrerX = $user->referral->referrer;
      
      $referralService = new ReferralService(new Referral());
      $referralService->setVideoDownlineBonus($referrerX->id, $referredX->referred_user_id, $videoId, $amountFinal);
      return downlineBonusDistribution($referrerX, $videoId, $amount, $bonusPercent, false);
    }
  }
}