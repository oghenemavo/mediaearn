<?php

namespace App\Http\Controllers\Api;

use App\Contracts\IUser;
use App\Enums\PaymentStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Transaction;
use App\Services\FlutterWaveService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function __construct(protected FlutterWaveService $flwService, protected IUser $userRepository)
    {
        $this->flwService = $flwService;
        $this->userRepository = $userRepository;
    }

    public function makeSubscriptionPayment(Request $request, Plan $plan)
    {
        $preferences = json_decode(base64_decode($request->preferences), true);
        $preferences['tx_ref'] = Str::uuid();
        $preferences['amount'] = (float) $plan->meta->get('set_discount') ? $plan->meta->get('discount') : $plan->price;
        $preferences['status'] = PaymentStatusEnum::OPENED;

        // insert into transactions table
        if(Transaction::create($preferences)) {
            return $this->flwService->setGateway($preferences);
        }
        return response()->json([
            'status' => 'failed',
            'message' => 'Unable to start gateway, please try again',
        ]);
    }

    public function paymentCallback(Request $request)
    {
        if ($request->query('status') === 'successful') {
            $transaction = Transaction::query()->where('tx_ref', $request->query('tx_ref'))->first();
            $response = (object) $this->flwService->verifyPayment($request->query('transaction_id'));
            
            if (
                $response->data['status'] === "successful"
                && $response->data['amount'] == $transaction->amount 
                && $response->data['currency'] === "NGN"
            ) {
                // Success! Confirm the customer's payment
                $transaction->status = PaymentStatusEnum::SUCCESS;
                $transaction->confirmed_at = Carbon::now();
                $transaction->save();

                // set membership & referrals bonus on signup
                $this->userRepository->createMembership($transaction->user_id, $transaction->tx_ref, $transaction->amount);
            } else {
                // Inform the customer their payment was unsuccessful
                $transaction->status = PaymentStatusEnum::FAILED;
                $transaction->save();
            }
            return redirect()->route('pricing', ['ref' => $request->query('tx_ref')]);
        }
    }

    public function fetchTransfer($transferId)
    {
        return $this->flwService->getTransfer($transferId);
    }
}
