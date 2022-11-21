<?php

namespace App\Repositories;

use App\Contracts\IUser;
use App\Enums\UserStatusEnum;
use App\Models\User;
use App\Services\ReferralService;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;

class UserRepository implements IUser
{
    public function __construct(
        protected User $user,
        protected ReferralService $referral,
        protected WalletService $wallet
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

}