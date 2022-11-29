<?php

namespace App\Services;

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
            'redirect_url' => 'http://127.0.0.1:8000/api/payment-callback',
            'meta' => [
                'consumer_id' => $data['user_id'],
                // 'consumer_mac' => '92a3-912ba-1192a'
            ],
            'customer' => [
                'email' => $data['email'],
                // 'phonenumber' => '080****4528',
                'name' => $data['name']
            ],
            'customizations' => [
                'title' => 'Pied Piper Payments',
                'logo' => 'http://www.piedpiper.com/app/themes/joystick-v27/images/logo.png'
            ]
        ];

        $response = Http::withToken($this->token)->post($url, $payload);
        // var_dump();
        return $response->json();
    }

    public function verifyPayment(string $transactionId)
    {
        $url = $this->url . "/transactions/{$transactionId}/verify";
        $response = Http::withToken($this->token)->get($url);
        return $response->json();
    }
}