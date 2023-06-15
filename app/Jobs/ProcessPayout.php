<?php

namespace App\Jobs;

use App\Models\AppSetting;
use App\Models\Charge;
use App\Models\Payout;
use App\Models\Wallet;
use App\Services\FlutterWaveService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessPayout implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    /**
     * Execute the job.
     *
     * @param  App\Services\FlutterWaveService  $processor
     * @return void
     */
    public function handle(FlutterWaveService $processor)
    {
        $transferCharges = AppSetting::where('slug', 'transfer_charges')->first()->value ?? 30;
        $xPayout = Payout::find($this->data['payout_id']);

        Log::info('is there a charge already => ' , [!empty($xPayout->charge?->amount)]);
        Log::info('is it valid for charges => ' , [($xPayout->amount - $transferCharges >= 0)]);

        // check if charges exists
        if (empty($xPayout->charge?->amount) && ($xPayout->amount - $transferCharges >= 0)) {
            // set transfer charge
            Charge::create([
                'payout_id' => $xPayout->id,
                'user_id' => $xPayout->user_id,
                'amount' => $transferCharges,
            ]);

            Log::info('Charges Created');

            // update transfer amount
            $xPayout->amount -= $transferCharges;
            $xPayout->save();

            // update payload amount
            $this->data['amount'] = $xPayout->amount;
        }

        // initiate transfer
        $response = $processor->transfer($this->data);

        Log::info(' payout response => ' , $response);

        if (strtolower($response['status']) == 'error' || (isset($response['data']['status']) && $response['data']['status'] == 'failed')) {
            $payout = Payout::where('reference', $this->data['reference'])->first();

            // refund user
            $wallet = Wallet::where('user_id', $payout->user->id)->first();

            // check if charges exists
            if (!empty($payout->charge?->amount)) {

                // update transfer amount to original
                $payout->amount += ($payout->charge?->amount ?? 0);
                $payout->save();

                // update payload amount
                $this->data['amount'] = $payout->amount;
            }

            $wallet->balance += $this->data['amount'];
            $wallet->ledger_balance -= $this->data['amount'];
            $wallet->save();

            // set payout status
            $payout->message = $response['message'];
            $payout->status = 'FAILED';
            $payout->save();
        } else {
            $meta = $response['data'] ?? null;
            if ($meta) {
                // get requested payout
                $payout = Payout::where('reference', $meta['reference'])->first();

                if ($payout) {
                    // set transfer id
                    if (strtolower($meta['status']) == 'new') {
                        $payout->transfer_id = $meta['id'] ?? null;
                    }

                    // update payout info
                    $payout->meta = $meta;
                    $payout->message = $meta['complete_message'];
                    $payout->status = $meta['status']; // NEW, ERROR, FAILED
                    return $payout->save();
                }
            }
        }
        return false;
    }
}
