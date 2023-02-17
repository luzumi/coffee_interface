<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TurnRelaisOn extends Controller
{
    public function sendStripeWebhook()
    {
        try {
            $client = new Client(['base_uri' => 'http://192.168.2.179',
                'timeout' => 2.0,
                'verify' => false,
                'http_errors' => false,
                'allow_redirects' => false,
                'debug' => false,
                'cookies' => true,
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'User-Agent' => 'Laravel/8.0.0 (GuzzleHttp/7.0.1)'
                ],
                'action' => 'turn_on',
            ]);
        } catch (\Exception $e) {
            Log::info('Could not connect to Raspberry Pi: ' . $e->getMessage());
        }
        try {
            $response = $client->post('http://127.0.0.1:5000/webhook', [
                'auth' => ['stripe_secret_key', ''],
                'json' => [
                    'url' => 'http://127.0.0.1:5000/webhook',
                    'events' => ['charge.succeeded'],
                    'action' => 'turn_on'
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ]
            ]);

        } catch (GuzzleException $e) {
            Log::info('Could not send webhook to Raspberry Pi: ' . $e->getMessage());
        }

    }
}

