<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'meta' => AsCollection::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function charge()
    {
        return $this->hasOne(Charge::class);
    }

}
