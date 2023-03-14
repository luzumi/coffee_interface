<?php

namespace App\Services;

use App\Models\RFID_Tag;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
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

        // Festlegen des aktuellen Benutzers anhand der empfangenen Benutzer-ID
        $rfid_tag = RFID_Tag::where('tag_uid', $data['user_id'])->with('user')->first();
        $user_id = $rfid_tag->user->id;

        Log::info('Webhook data incoming: ' . json_encode($data));

        RaspUser::setRaspUser($user_id);

        // Rückgabe einer JSON-Antwort mit einem Status "success" und den empfangenen Daten
        return response()->json(['status' => 'success', 'data' => $data]);
    }



    /**
     * @return JsonResponse
     */
    public function getWebhookData()
    {
        // Abrufen der aktuellen Benutzer-ID
        $rasp_user_id = RaspUser::getRaspUserId();


        // Abrufen des Benutzers anhand der Benutzer-ID und
        // Rückgabe einer JSON-Antwort mit der Benutzer-ID und der Rolle des RFID-Tags
        $user = User::find($rasp_user_id);
        return response()->json(['data' => $rasp_user_id, 'role' => RFID_Tag::find($user->tag_id)->role]);
    }

    public function sendWebhookGetCoffee(string $coffeeCode): int
    {
        // Konfiguration laden und prüfen, ob der erste Eintrag vorhanden ist
        $config = config('webhook-client.configs.0');
        if (!$config) {
//            Log::error('Webhook configuration not found.');

            return 500; // HTTP-Statuscode für interne Serverfehler
        }

        // Webhook-URL und Guzzle-Client-URL aus der Konfiguration laden
        $clientUrl = config('webhook-client.configs.0.guzzle_http_client');
        $webhookUrl = config('webhook-client.configs.0.webhook_url');

        // Guzzle-Client mit Basis-URI und Aktion erstellen
        try {
            $client = new Client(['base_uri' => $webhookUrl,
                'action' => $coffeeCode,
            ]);
        } catch (\Exception $e) {
            // Protokollieren einer Fehlermeldung, falls der Client nicht erstellt werden konnte
//            Log::error('Could not create Guzzle client: ' . $e->getMessage());

            return 500; // HTTP-Statuscode für interne Serverfehler
        }

        // Webhook-Anforderung senden
        try {
            $response = $client->post($webhookUrl, [
                'auth' => ['stripe_secret_key', '1'],
                'json' => [
                    'url' => $webhookUrl,
                    'events' => ['charge.succeeded'],
                    'action' => $coffeeCode,
                ],
            ]);
            // Erfolgsmeldung protokollieren
//            Log::info('Webhook sent to Raspberry Pi: ' . $client->getConfig('action'));
            // HTTP-Statuscode der Antwort zurückgeben
            return $response->getStatusCode();
        } catch (GuzzleException $e) {
            // Protokollieren einer Fehlermeldung, falls die Webhook-Anforderung nicht gesendet werden konnte
//            Log::error('Could not send webhook to Raspberry Pi: ' . $e->getMessage());
            return 500; // HTTP-Statuscode für interne Serverfehler
        }
    }

    public function ALTsendWebhookGetCoffee()
    {
        try {
            $client = new Client(['base_uri' => config('webhook-client.configs.0.webhook_url'),
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
            $response = $client->post(config('webhook-client.configs.0.webhook_url'), [
                'auth' => ['stripe_secret_key', '1'],
                'json' => [
                    'url' => config('webhook-client.configs.0.webhook_url'),
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



    public static function setId(): Redirector|Application|RedirectResponse
    {
        // Setzen der aktuellen Benutzer-ID auf 0 oder 6, abhängig von der aktuellen Benutzer-ID
        // (benötigt für den klickbaren Buttons auf der Startseite)
        $id = RaspUser::getRaspUserId()==1 ? 0 : 1;
        RaspUser::setRaspUser($id);

        return redirect('/');
    }
}
