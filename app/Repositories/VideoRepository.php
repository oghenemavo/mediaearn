<?php

namespace App\Repositories;

use App\Contracts\IVideo;
use App\Enums\VideoTypeEnum;
use App\Models\Video;
use Illuminate\Support\Str;

class VideoRepository implements IVideo
{
    public function __construct(protected Video $video)
    {
        $this->video = $video;
    }

    public function createVideo(array $attributes)
    {
        $url = $this->setVideoUrl($attributes);
        // dd($url);
        return $this->video->create([
            'category_id' => data_get($attributes, 'category_id'),
            'title' => data_get($attributes, 'title'),
            'slug' => Str::of(data_get($attributes, 'title'))->slug('-') . '-' . uniqid(),
            'description' => $this->clean(data_get($attributes, 'description')),
            'video_type' => data_get($attributes, 'video_type'),
            'url' => $url,
            'cover' => $this->uploadFile('covers', 'cover'),
            'length' => data_get($attributes, 'length'),
            'charges' => data_get($attributes, 'charges'),
            'earnable' => data_get($attributes, 'earnable'),
            'earnable_ns' => data_get($attributes, 'earnable_ns'),
            'earned_after' => data_get($attributes, 'earned_after'),
        ]);
    }

    protected function setVideoUrl(array $attributes)
    {
        $videoUrl = '';
        $videoType = data_get($attributes, 'video_type');
        if ($videoType == VideoTypeEnum::YOUTUBE->value) {
            $videoUrl .= 'https://youtube.com/watch?v=' . data_get($attributes, 'video_id');
        } elseif ($videoType == VideoTypeEnum::UPLOAD->value) {
            $videoUrl .=  $this->uploadFile('videos', 'video_file');
        }
        return $videoUrl;
    }

    protected function uploadFile($dir, $fileName)
    {
        $fileObject = request()->file($fileName);
        $file = uniqid($fileName . '_') . '.' . $fileObject->extension();
        $fileObject->move(public_path('/' . $dir), $file);
        return $file;
    }

    protected function clean($string)
    {
        $string = trim($string);
        $string = stripslashes($string);
        $string = htmlspecialchars($string, ENT_QUOTES);
        $string = filter_var($string, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH);
        return $string;
    }
}