<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    /**
     * Get the cover paths.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function material(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('promotions/' . $value),
        );
    }
    
}
