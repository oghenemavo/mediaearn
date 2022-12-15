<?php

namespace App\Http\Controllers\User;

use App\Contracts\IUser;
use App\Enums\VideoTypeEnum;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessPayout;
use App\Models\AppSetting;
use App\Models\Payout;
use App\Models\Video;
use App\Models\VideoViewLog;
use App\Services\FlutterWaveService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    public function __construct(protected IUser $userRepository, FlutterWaveService $flwService)
    {
        $this->userRepository = $userRepository;
        $this->flwService = $flwService;
    }

    public function video(Video $video)
    {
        $data['page_title'] = $video->title;
        $data['video'] = $video;
        $data['video_views'] = VideoViewLog::where('video_id', $video->id)->count() ?? 0;

        $user = auth()->guard('web')->user();
        $data['is_viewed'] = (bool) VideoViewLog::where('video_id', $video->id)->where('user_id', $user?->id)?->count() ?? false;
        $data['user'] = $user;
        $data['video_link'] = $video->video_type == VideoTypeEnum::YOUTUBE ? $video->url : $video->video_url;
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

        }
        $data['duration'] = function($seconds) {
            if ($seconds > 60) {
                return floor($seconds/60);
            }
            return 1;
        };
        
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
            
            $reward = VideoViewLog::firstOrCreate(
                ['user_id' => $user->id, 'video_id' => $video->id],
                $data
            );

            // referral bonus for video watched
            $this->userRepository->referralVideoReward($user, $video->id, $data['earned_amount']);
            
            if ($reward->wasRecentlyCreated) {
                $user->wallet->balance += $data['earned_amount'];
                $user->wallet->save();

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
        $user = auth()->guard('web')->user();
        $data['bank'] = $user->bank_code;
        $data['account_number'] = $user->account_number;
        $data['min'] = AppSetting::where('slug', 'min_payout')->first()->value ?? 100;
        $data['balance'] = $user->wallet->balance;
        return view('user.earnings', $data);
    }

    public function requestPayout(Request $request)
    {
        $user = auth()->guard('web')->user();
        $balance = $user->wallet->balance;
        $minPayout = AppSetting::where('slug', 'min_payout')->first()->value ?? 100;

        if ($balance >= $minPayout) {
            $user->wallet->balance = '0.00';
            $user->wallet->ledger_balance += $balance;

            // verify account details
            $response = $this->flwService->resolveAccount($user->bank_code, $user->account_number);

            if ($response['status'] == 'success') {
                if ($user->wallet->save()) {
                    $data = [
                        'user_id' => $user->id,
                        'amount' => $balance,
                        'reference' => str::uuid(),
                        // 'reference' => bin2hex(openssl_random_pseudo_bytes(10)),
                        'status' => 'REQUESTED',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                    Payout::create($data);
                    unset($data['user_id'], $data['created_at'], $data['updated_at']);
                    $data['bank_code'] = $user->bank_code;
                    $data['account_number'] = $user->account_number;
        
                    ProcessPayout::dispatch($data);
                    return response()->json(['success' => true]);
                }
            }
            return response()->json(['success' => false, 'message' => $response['message']]);
        }
        return response()->json(['success' => false]);
    }

}
