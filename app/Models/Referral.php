<?php

namespace App\Models;

use App\Enums\ReferralTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'referral_type' => ReferralTypeEnum::class,
    ];
}
