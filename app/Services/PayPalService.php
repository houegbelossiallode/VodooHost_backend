<?php 
namespace App\Services;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\LiveEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PayPalService
{
    private function client()
    {
        $clientId = config('paypal.client_id');
        $clientSecret = config('paypal.client_secret');

        if (config('paypal.mode') === 'live') {
            $liveClass = '\PayPalCheckoutSdk\Core\LiveEnvironment';
            if (class_exists($liveClass)) {
                $env = new $liveClass($clientId, $clientSecret);
            } else {
                // If the LiveEnvironment class is not available, fail fast with a clear message.
                throw new \RuntimeException('PayPal LiveEnvironment class not found; ensure the PayPal SDK is installed or switch to sandbox mode.');
            }
        } else {
            $env = new SandboxEnvironment($clientId, $clientSecret);
        }

        return new PayPalHttpClient($env);
    }

    public function createOrder($amount, $currency, $successUrl, $cancelUrl)
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => $currency,
                    'value' => number_format($amount, 2, '.', '')
                ]
            ]],
            'application_context' => [
                'return_url' => $successUrl,
                'cancel_url' => $cancelUrl,
            ],
        ];

        $response = $this->client()->execute($request);

        foreach ($response->result->links as $link) {
            if ($link->rel === 'approve') {
                return $link->href;
            }
        }

        throw new \Exception('Lien PayPal introuvable');
    }

    public function captureOrder($orderId)
    {
        $request = new OrdersCaptureRequest($orderId);
        $request->prefer('return=representation');

        return $this->client()->execute($request);
    }
}