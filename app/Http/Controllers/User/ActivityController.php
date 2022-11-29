<?php

namespace App\Http\Controllers\User;

use App\Enums\VideoTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\VideoReward;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function video(Video $video)
    {
        $data['page_title'] = $video->title;
        $data['video'] = $video;
        return view('user.video', $data);
    }

    public function getReward(Request $request, Video $video)
    {
        $user = auth()->guard('web')->user();

        $playedTime = $request->played_time;

        // dump($playedTime);

        $validPlayedTime = filter_var($playedTime, FILTER_VALIDATE_FLOAT, [
            'options' => [
                'min_range' => $video->earned_after, 
                'max_range' => $playedTime + 1,
            ]
        ]);

        // dd($validPlayedTime);

        if ($validPlayedTime) {
            $data = [
                'user_id' => $user->id,
                'video_id' => $video->id,
                'watched' => $playedTime,
                'earned_amount' => $video->earnable,
            ];
            
            $reward = VideoReward::firstOrCreate(
                ['user_id' => $user->id, 'video_id' => $video->id],
                $data
            );
            
            if ($reward->wasRecentlyCreated) {
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false]);
        }
        return response()->json(['error' => true]);
    }

}
