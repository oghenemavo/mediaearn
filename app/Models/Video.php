<?php

namespace App\Models;

use App\Enums\VideoTypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    /**
     * Get the cover paths.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function cover(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('covers/' . $value),
        );
    }

    /**
     * Get the video's path.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function videoUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => 
                $attributes['video_type'] == VideoTypeEnum::UPLOAD->value ? 
                asset('videos/' . $attributes['url']) : 'https://www.youtube.com/embed/' . $attributes['url'],
        );
    }

}
