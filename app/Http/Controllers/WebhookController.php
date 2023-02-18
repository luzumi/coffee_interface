<?php

namespace App\Http\Controllers;

use App\Services\RaspUser;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function handleWebhook(Request $request)
    {
        $data = $request->json()->all();

        RaspUser::setRaspUser($data['user_id']);

        return response()->json(['status' => 'success', 'data' => $data]);
    }


    /**
     * @return JsonResponse
     */
    public function getWebhookData()
    {
        $rasp_user_id = RaspUser::getRaspUser();

        return response()->json(['data' => $rasp_user_id]);
    }

    public function sendWebhookTurnOn()
    {
        try {
            $client = new Client(['base_uri' => 'http://192.168.2.179',
//                'timeout' => 2.0,
//                'verify' => false,
//                'http_errors' => false,
//                'allow_redirects' => false,
//                'debug' => false,
//                'cookies' => true,
//                'headers' => [
//                    'Accept' => 'application/json',
//                    'Content-Type' => 'application/json',
//                    'User-Agent' => 'Laravel/8.0.0 (GuzzleHttp/7.0.1)'
//                ],
                'action' => 'turn_on',
            ]);

        } catch (\Exception $e) {
            Log::info('Could not make Clienti: ' . $e->getMessage());
        }
        try {
            $response = $client->post('http://127.0.0.1:5000/webhook', [
                'auth' => ['stripe_secret_key', '1'],
                'json' => [
                    'url' => 'http://127.0.0.1:5000/webhook',
                    'events' => ['charge.succeeded'],
                    'action' => 'turn_on'
                ],
//                'headers' => [
//                    'Content-Type' => 'application/json',
//                    'Accept' => 'application/json'
//                ]
            ]);
            Log::info('Webhook sent to Raspberry Pi: ' . $client->getConfig('action'));

        } catch (GuzzleException $e) {
            Log::info('Could not send webhook to Raspberry Pi: ' . $e->getMessage());
        }

        return back();
    }
}
