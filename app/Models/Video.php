<?php

namespace App\Models;

use App\Enums\VideoTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'video_type' => VideoTypeEnum::class,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
