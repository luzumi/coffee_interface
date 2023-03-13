<?php

namespace App\Services;

use App\Models\RFID_Tag;
use App\Models\User;
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
        // Extrahieren der JSON-Daten aus der Anfrage
        $data = $request->json()->all();

        // Festlegen des aktuellen Benutzers anhand der empfangenen Benutzer-ID
        RaspUser::setRaspUser($data['user_id']);

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
            Log::error('Webhook configuration not found.');
            return 500; // HTTP-Statuscode für interne Serverfehler
        }

        // Webhook-URL und Guzzle-Client-URL aus der Konfiguration laden
        $webhookUrl = config('webhook-client.configs.0.webhook_url');
        $clientUrl = config('webhook-client.configs.0.guzzle_http_client');

        // Guzzle-Client mit Basis-URI und Aktion erstellen
        try {
            $client = new Client([
                'base_uri' => $clientUrl,
                'action' => $coffeeCode,
            ]);
        } catch (\Exception $e) {
            // Protokollieren einer Fehlermeldung, falls der Client nicht erstellt werden konnte
            Log::error('Could not create Guzzle client: ' . $e->getMessage());
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
            Log::info('Webhook sent to Raspberry Pi: ' . $client->getConfig('action'));
            // HTTP-Statuscode der Antwort zurückgeben
            return $response->getStatusCode();
        } catch (GuzzleException $e) {
            // Protokollieren einer Fehlermeldung, falls die Webhook-Anforderung nicht gesendet werden konnte
            Log::error('Could not send webhook to Raspberry Pi: ' . $e->getMessage());
            return 500; // HTTP-Statuscode für interne Serverfehler
        }
    }



    public static function setId()
    {
        // Setzen der aktuellen Benutzer-ID auf 0 oder 6, abhängig von der aktuellen Benutzer-ID
        // (benötigt für den klickbaren Buttons auf der Startseite)
        $id = RaspUser::getRaspUserId()==6 ? 0 : 6;
        RaspUser::setRaspUser($id);
    }
}
