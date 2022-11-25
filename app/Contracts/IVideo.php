<?php

namespace App\Contracts;

use App\Models\Video;

interface IVideo
{
    public function createVideo(array $value);
    
    public function editVideoPost(array $value, Video $video);
}