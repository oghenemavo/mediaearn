<?php

namespace App\Http\Controllers\User;

use App\Contracts\IUser;
use App\Enums\VideoTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Payout;
use App\Models\Referral;
use App\Models\Video;
use App\Models\VideoViewLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __construct(protected IUser $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function video(Video $video)
    {
        // var_dump($this->userRepository->referralVideoReward(auth()->guard('web')->user(), 2, 100));
        // exit;

        $data['page_title'] = $video->title;
        $data['video'] = $video;
        // $data['video_type'] = $video->video_type;
        $data['video_views'] = VideoViewLog::where('video_id', $video->id)->count() ?? 0;

        $user = auth()->guard('web')->user();
        $data['is_viewed'] = (bool) VideoViewLog::where('video_id', $video->id)->where('user_id', $user?->id)?->count() ?? false;
        $data['user'] = $user;
        $data['video_link'] = $video->video_type == VideoTypeEnum::YOUTUBE ? $video->url : $video->video_url;

        // $data['tax'] = 0.01 * (Setting::where('slug', 'payout_tax_percentage')->first()->meta ?? '0.1');
        if ($user) {
            $membership = $this->userRepository->getMembership($user->id);
            $data['is_subscribed'] = $membership?->count() ?? 0;

            if ($data['is_subscribed']) {
                $data['max_videos'] = $membership->plan->meta->get('max_views');
                $data['earnable'] = $video->earnable;
            } else {
                $data['earnable'] = $video->earnable_ns;
                $data['max_videos'] = AppSetting::where('slug', 'max_videos_non_sub')->first()->value;
            }
            
            // total videos watched today for any variant of user
            $data['watched_count'] = VideoViewLog::where('user_id', $user->id)->whereDate('created_at', Carbon::today())->count();
            $data['is_watched'] = VideoViewLog::where('user_id', $user->id)->where('video_id', $video->id)->count();

            // video not watched
            if (!$data['is_watched'] && ($data['watched_count'] >= $data['max_videos'])) {
                return redirect()->back()->with('sub_user', 'Maximum numbers of videos watched Today');
            }

            // dd($data['max_videos']);
            

            // dd($membership->plan->meta->get('max_views'));


            // $data['is_subscribed'] = is_null($user->membership);


            // subscribed users max videos
            // $data['max_videos'] = AppSetting::query()->where('slug', 'max_videos_sub')->get()->first()->value;

            // non subscribed users max videos
            // $data['max_videos_ns'] = AppSetting::where('slug', 'max_videos_non_sub')->first()->value;

            // echo '<pre>' . var_export($data['is_watched'], true) . '</pre>';
            
            // if (!$data['is_watched'] && !$data['is_subscribed'] && ($data['watched_count'] >= $data['max_videos'])) { // subscription exists
            //     return redirect()->back()->with('sub_user', 'Maximum numbers of videos watched Today');
            // } elseif (!$data['is_watched'] && $data['is_subscribed'] && ($data['watched_count'] >= $data['max_videos_ns'])) {
            //     return redirect()->back()->with('info', 'Maximum numbers of videos watched Today, Subscribe now to watch more');
            // }
        }
        $data['duration'] = function($seconds) {
            if ($seconds > 60) {
                return floor($seconds/60);
            }
            return 1;
        };
        // $data['earning'] = function($earnings = ['earnable' => 0, 'earnable_ns' => 0]) use($data) {
        //     // return auth()->check() ?  : $earnings['earnable_ns'];
        //     if (auth()->guard('web')->check()) {
        //         if (!$data['is_subscribed']) {
        //             return $earnings['earnable'] - ($earnings['earnable'] * $data['tax']);
        //         } else {
        //             return $earnings['earnable_ns'] - ($earnings['earnable_ns'] * $data['tax']);
        //         }
        //     }
        //     return $earnings['earnable'] - ($earnings['earnable'] * $data['tax']);
        // };
        $data['current_time'] = Carbon::now();

        return view('video', $data);
    }

    public function getReward(Request $request, Video $video)
    {
        $user = auth()->guard('web')->user();

        $playedTime = $request->played_time;

        $validPlayedTime = filter_var($playedTime, FILTER_VALIDATE_FLOAT, [
            'options' => [
                'min_range' => $video->earned_after, 
                'max_range' => $playedTime + 1,
            ]
        ]);

        if ($validPlayedTime) {
            $data = [
                'user_id' => $user->id,
                'video_id' => $video->id,
                'watched' => $playedTime,
            ];

            $membership = $this->userRepository->getMembership($user->id);
            $data['is_subscribed'] = $membership?->count() ?? false;

            if ($data['is_subscribed']) {
                $data['earned_amount'] = $video->earnable;
            } else {
                $data['earned_amount'] = $video->earnable_ns;
            }

            // if (! is_null(auth()->guard('web')->user()->membership)) { // if a subscriber
            //     $data['earned_amount'] = $video->earnable;
            // } else {
            //     $data['earned_amount'] = $video->earnable_ns;
            // }
            
            $reward = VideoViewLog::firstOrCreate(
                ['user_id' => $user->id, 'video_id' => $video->id],
                $data
            );

            // referral bonus for video watched
            $this->userRepository->referralVideoReward($user, $video->id, $data['earned_amount']);
            
            if ($reward->wasRecentlyCreated) {

                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false]);
        }
        return response()->json(['error' => true]);
    }

    public function referrals()
    {
        $data['page_title'] = 'Referrals';
        return view('user.referrals', $data);
    }

    public function rewards()
    {
        $data['page_title'] = 'Rewards';
        return view('user.rewards', $data);
    }

    public function transactions()
    {
        $data['page_title'] = 'Transactions';
        return view('user.transactions', $data);
    }

    public function earnings()
    {
        $data['page_title'] = 'Earnings';
        $data['balance'] = auth()->guard('web')->user()->wallet->balance;
        $data['min'] = AppSetting::where('slug', 'min_payout')->first()->value ?? 100;
        return view('user.earnings', $data);
    }

    public function requestPayout(Request $request)
    {
        $user = auth()->guard('web')->user();
        $balance = $request->balance;
        $user->wallet->balance = '0.00';
        $user->wallet->ledger_balance += $balance;
        if ($user->wallet->save()) {
            $payout = [
                'user_id' => $user->id,
                // 'reason' => 'Payout',
                'amount' => $balance,
                'reference' => bin2hex(openssl_random_pseudo_bytes(10)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            Payout::create($payout);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

}
