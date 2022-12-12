<?php

namespace App\Console\Commands;

use App\Models\Payout;
use App\Models\Wallet;
use App\Services\FlutterWaveService;
use Illuminate\Console\Command;

class VerifyPayout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:payout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify Requested Payout';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(FlutterWaveService $flwService)
    {
        $payouts = Payout::where('status', 'NEW')->get();
        // 1. Get Data
        $responses = $flwService->getTransfer($payouts);

        // var_dump(count($responses));
        // exit;

        if (is_array($responses) && count($responses) > 0) {
            foreach($responses as $response) {
                if (strtolower($response['status']) == 'success' && $response['data']) {
                    $responseData = $response['data'];
                    $message = $responseData['complete_message'];
                    $payout = Payout::where('transfer_id', $responseData['id'])->first();
                    
                    if (strtolower($responseData['status']) == 'successful') {
                        $payout->update([
                            'status' => 'SUCCESS', 
                            'is_notified' => '1', 
                            'message' => $message
                        ]);
                    } elseif (strtolower($responseData['status']) == 'failed') { // failed // pending // etc
                        $payout->update([
                            'status' => 'FAILED',
                            'message' => $message,
                        ]);
        
                        $user_wallet = Wallet::where('user_id', $payout->user_id)->first();
                        if ($user_wallet) {
                            $user_wallet->ledger_balance -= $payout->amount;
                            $user_wallet->balance += $payout->amount;
                            $user_wallet->save();
                        }
                    }  else { // pending // etc
                        $payout->update([
                            'status' => $responseData['status'],
                            'message' => $message
                        ]);
                    } 
        
                }
            }
        }

        return $this->info('All transfers status verified');
    }
}
