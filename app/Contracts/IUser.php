<?php

namespace App\Contracts;

interface IUser
{
    public function createUser(array $value);
    public function createMembership($user_id, $tx_ref, $amount);
    public function referralVideoReward($user, $videoId);
    public function getMembership($userId);
}