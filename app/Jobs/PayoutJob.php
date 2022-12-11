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

class PayoutJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public FlutterWaveService $flwService;
    public $payload;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->flwService = new FlutterWaveService();
        $response = $this->flwService->transfer($this->payload);
        if (strtolower($response['status']) == 'success') {
            $meta = $response['data'];
            $payoutInfo = Payout::where('reference', $meta['reference'])->first();
            if ($payoutInfo) {
                $payoutInfo->meta = json_encode($meta);
                $payoutInfo->status = $meta['status'];
                return $payoutInfo->save();
            }
        }
        return false;
    }
}
