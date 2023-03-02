<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookService
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
        $rasp_user_id = RaspUser::getRaspUserId();

        return response()->json(['data' => $rasp_user_id]);
    }

    public function sendWebhookGetCoffee($coffee_name)
    {
        try {
            $client = new Client(['base_uri' => 'http://192.168.2.179',
                'action' => $coffee_name,
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
                    'action' => $coffee_name,
                ],
            ]);
            Log::info('Webhook sent to Raspberry Pi: ' . $client->getConfig('action'));

        } catch (GuzzleException $e) {
            Log::info('Could not send webhook to Raspberry Pi: ' . $e->getMessage());
        }

        return back();
    }

    public static function setId()
    {
        $id = RaspUser::getRaspUserId()==21 ? 0 : 21;

        RaspUser::setRaspUser($id);

        return redirect('/');
    }
}
