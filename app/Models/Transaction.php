<?php

namespace App\Models;

use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    
    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'status' => PaymentStatusEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
