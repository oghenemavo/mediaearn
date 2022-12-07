<?php

namespace App\Models;

use App\Enums\ReferralTypeEnum;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'meta' => AsCollection::class,
        'referral_type' => ReferralTypeEnum::class,
    ];

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_user_id');
    }
    
    public function referred()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }

}
