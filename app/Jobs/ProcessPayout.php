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
        $response = $processor->transfer($this->data);
        if ($response) {
            $meta = $response['data'] ?? null;
            if ($meta) {
                $payout = Payout::where('reference', $meta['reference'])->first();
                
                if (strtolower($response['status']) == 'error' || strtolower($meta['status']) == 'failed') {
                    $payout->user->wallet->balance += $meta['amount'];
                    $payout->user->wallet->ledger_balance -= $meta['amount'];
                    $payout->user->wallet->save();
                } 

                if ($payout) {
                    $payout->meta = $meta;
                    $payout->message = $meta['complete_message'];
                    $payout->status = $meta['status'];
                    return $payout->save();
                }

            }
        }
        return false;
    }
}
