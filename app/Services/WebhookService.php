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

    public function sendWebhookGetCoffee($coffee_code)
    {
        // Abrufen der Webhook-URL aus der Umgebungsvariablen GUZZLE_HTTP_CLIENT
        $webhook_url = config('guzzle_http_client');

        try {
            // Erstellen eines Guzzle-HTTP-Clients mit der Basis-URI und der Aktion
            $client = new Client(['base_uri' => $webhook_url,
                'action' => $coffee_code,
            ]);

        } catch (\Exception $e) {
            // Protokollieren einer Fehlermeldung, falls der Client nicht erstellt werden konnte
            Log::info('Could not make Client: ' . $e->getMessage());
        }

        try {
            // Senden einer Webhook-Anforderung an die angegebene URL mit den angegebenen Parametern
            $response = $client->post(config('webhook_ip'), [
                'auth' => ['stripe_secret_key', '1'],
                'json' => [
                    'url' => config('webhook_ip'),
                    'events' => ['charge.succeeded'],
                    'action' => $coffee_code,
                ],
            ]);
            // Protokollieren einer Erfolgsmeldung mit der durchgeführten Aktion
            Log::info('Webhook sent to Raspberry Pi: ' . $client->getConfig('action'));

            // Rückgabe des Statuscodes der Antwort
            return $response->getStatusCode();

        } catch (GuzzleException $e) {
            // Protokollieren einer Fehlermeldung, falls die Webhook-Anforderung nicht gesendet werden konnte
            Log::info('Could not send webhook to Raspberry Pi: ' . $e->getMessage());
            // Zurückkehren zum Aufrufpunkt
            return back();
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
