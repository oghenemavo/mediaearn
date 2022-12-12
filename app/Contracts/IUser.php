<?php

namespace App\Contracts;

interface IUser
{
    public function createUser(array $value);
    public function createMembership($user_id, $tx_ref, $amount, $planId);
    public function referralVideoReward($user, $videoId, $amount);
    public function getMembership($userId);
}