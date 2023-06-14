<?php

namespace App\Console\Commands;

use App\Jobs\ProcessPayout;
use App\Models\AppSetting;
use App\Models\Charge;
use App\Models\Payout;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RequeryRequestedPayout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'requery:requested_payout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-query Requested Payout that has not been processed for over 10 hours';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $payouts = Payout::where('status', 'Requested')->where('created_at', '<=', Carbon::now()->subHours(10)->toDateTimeString())->get();

        if (count($payouts) > 0) {
            foreach ($payouts as $key => $payout) {

                $data = [
                    'user_id' => $payout->user_id,
                    'payout_id' => $payout->id,
                    'amount' => $payout->amount,
                    'reference' => $payout->reference,
                    'bank_code' => $payout->user->bank_code,
                    'account_number' => $payout->user->account_number,
                ];

                // Job
                ProcessPayout::dispatch($data);
            }
        }

        return $this->info('All Old Requested Payout  verified');
    }
}
