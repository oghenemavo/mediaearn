<?php

namespace App\Contracts;

use App\Models\Video;

interface IVideo
{
    public function create(array $value);
    
    public function edit(array $value, Video $video);
}