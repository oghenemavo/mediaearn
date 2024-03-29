<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class FlutterWaveService
{
    protected string $url;
    protected string $token;

    public function __construct()
    {
        $this->url = config('app.flw.base_url');
        $this->token = config('app.flw.secret_key');
    }

    public function setGateway(array $data)
    {
        $url = $this->url . '/payments';
        $payload = [
            'tx_ref' => $data['tx_ref'],
            'amount' => $data['amount'],
            'currency' => 'NGN',
            'redirect_url' => config('app.url') . '/api/payment-callback',
            'meta' => [
                'consumer_id' => $data['user_id'],
                'payment_type' => 'Gateway',
                'plan' => $data['plan'],
            ],
            'customer' => [
                'email' => $data['email'],
                // 'phonenumber' => '080****4528',
                'name' => $data['name']
            ],
            'customizations' => [
                'title' => 'CatnetInclusive-Earnerview',
                'logo' => asset('assets/images/earners-logo.png')
            ]
        ];

        $response = Http::withToken($this->token)->post($url, $payload);
        return $response->json();
    }

    public function verifyPayment(string $transactionId)
    {
        $url = $this->url . "/transactions/{$transactionId}/verify";
        $response = Http::withToken($this->token)->get($url);
        return $response->json();
    }

    public function fetchBanks()
    {
        $url = $this->url . '/banks/NG';
        $response = Http::withToken($this->token)->get($url);
        return $response->json();
    }

    public function resolveAccount(string $bankCode, string $accountNumber)
    {
        $url = $this->url . '/accounts/resolve';
        $payload = [
            'account_number' => $accountNumber,
            'account_bank' => $bankCode,
        ];
        $response = Http::withToken($this->token)->post($url, $payload);
        return $response->json();
    }

    public function transfer(array $data)
    {
        $url = $this->url . '/transfers';
        $payload = [
            'account_bank' => $data['bank_code'],
            'account_number' => $data['account_number'],
            'amount' => $data['amount'],
            'narration' => 'Earnerview - Payout ' . uniqid(),
            'currency' => 'NGN',
            'reference' => $data['reference'],
            // 'callback_url' => 'https://www.flutterwave.com/ng/',
            'debit_currency' => 'NGN'
        ];

        $responses = Http::pool(fn (Pool $pool) => [
            $pool->withToken($this->token)->post($url, $payload),
        ]);
        return $responses[0]->json();
    }

    public function getTransfer($collection)
    {
        $responses = Http::pool(function (Pool $pool) use ($collection) {
            $url = $this->url . '/transfers/';

            return $collection->map(fn ($data) => $pool->withToken($this->token)->get($url . $data->transfer_id));
        });

        return $responses;
    }

}
