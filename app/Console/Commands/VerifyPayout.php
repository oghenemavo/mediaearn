<?php

namespace App\Console\Commands;

use App\Models\Charge;
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
        // Get Payout where status is NEW =>
        // Flutterwave sends "NEW" for a successful initiated transfer
        $payouts = Payout::where('status', 'NEW')->orWhere('status', 'PENDING')->get();

        // 1. Get Data
        $responses = $flwService->getTransfer($payouts);

        // echo '<pre>' . var_export($responses[0]['data'], true) . '</pre>';
        // die;

        if (is_array($responses) && count($responses) > 0) {
            foreach($responses as $response) {
                // first layer status
                if (strtolower($response['status']) == 'success' && $response['data']) {
                    $responseData = $response['data'];
                    $message = $responseData['complete_message'] ?? null;
                    $payout = Payout::where('transfer_id', $responseData['id'])->first();

                    $charges = Charge::where('payout_id', $payout->id)->first();

                    $user_wallet = Wallet::where('user_id', $payout->user_id)->first();
                    // second layer status
                    if (strtolower($responseData['status']) == 'successful') {
                        $payout->update([
                            'status' => 'successful',
                            'is_notified' => '1',
                            'message' => $message
                        ]);

                        if ($user_wallet) {
                            $totalPayoutAmount = $payout->amount + ($charges?->amount ?? 0);

                            // update wallet
                            $user_wallet->ledger_balance -= $totalPayoutAmount;
                            $user_wallet->save();
                        }

                        $charges->status = 1;
                        $charges->save();
                    } elseif (strtolower($responseData['status']) == 'failed') { // failed // pending // etc
                        $payout->update([
                            'status' => 'failed',
                            'message' => $message,
                        ]);

                        if ($user_wallet) {
                            $totalPayoutAmount = $payout->amount + ($charges?->amount ?? 0);

                            // update transfer amount to original
                            $payout->amount = $totalPayoutAmount;
                            $payout->save();

                            // update wallet
                            $user_wallet->ledger_balance -= $totalPayoutAmount;
                            $user_wallet->balance += $totalPayoutAmount;
                            $user_wallet->save();
                        }
                    }  else { // pending // etc
                        $payout->update([
                            'status' => strtolower($responseData['status']),
                            'message' => $message
                        ]);
                    }

                }
            }
        }

        return $this->info('All transfers status verified');
    }
}
