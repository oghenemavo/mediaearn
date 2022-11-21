<?php

namespace App\Services;

use App\Models\Wallet;

class WalletService
{
    public function __construct(protected Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    public function createWallet($user_id)
    {
        return $this->wallet->create(['user_id' => $user_id]);
    }
}