<?php

namespace App\Jobs;

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
        // initiate transfer 
        $response = $processor->transfer($this->data);

        Log::info(' payout response => ' , $response);

        if (strtolower($response['status']) == 'error' || (isset($response['data']['status']) && $response['data']['status'] == 'failed')) {
            $payout = Payout::where('reference', $this->data['reference'])->first();

            // refund user
            $wallet = Wallet::where('user_id', $payout->user->id)->first();
            
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
