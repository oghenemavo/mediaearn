<?php

namespace App\Jobs;

use App\Models\Payout;
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

        Log::info('IP: ' . request()->ip() . ' payout response => ' , $response);

        // check transfer fails
        if (strtolower($response['status']) == 'error') {
            $payout = Payout::where('reference', $this->data['reference'])->first();

            // revert amount
            $payout->user->wallet->balance += $this->data['amount'];
            $payout->user->wallet->ledger_balance -= $this->data['amount'];
            $payout->user->wallet->save();

            // update payout info
            $payout->message = $response['message'] ?? null;
            $payout->status = 'FAILED'; // NEW, ERROR, FAILED
        } else { // otherwise
            $meta = $response['data'] ?? null;
            if ($meta) {
                // get requested payout
                $payout = Payout::where('reference', $meta['reference'])->first();
                
                // if transfer fails
                if (strtolower($meta['status']) == 'failed') {
                    // revert amount
                    $payout->user->wallet->balance += $meta['amount'];
                    $payout->user->wallet->ledger_balance -= $meta['amount'];
                    $payout->user->wallet->save();
                }
    
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
