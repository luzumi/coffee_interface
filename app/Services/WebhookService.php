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
use Psr\Http\Message\ResponseInterface;

class WebhookService
{
    /**
     * Verarbeitet den empfangenen Webhook und speichert den Benutzer entsprechend.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        // Festlegen des aktuellen Benutzers anhand der empfangenen Benutzer-ID
        $rfidTag = RFID_Tag::where('tag_uid', $data['tag_uid'])->with('user')->first();
        $userId = $rfidTag->user->id;

        // Protokollieren der eingehenden Webhook-Daten
        Log::info('Webhook data incoming: ', $data);

        // Extrahieren der optionalen Parameter aus den empfangenen Daten
        $disruption = $data['disruption'] ?? false;
        $userNotFound = $data['user_not_found'] ?? false;
        $service = $data['service'] ?? false;

        // Aktualisieren des RaspUser-Eintrags in der Datenbank
        RaspUser::setRaspUser($userId, $disruption, $userNotFound, $service);

        // Rückgabe einer JSON-Antwort mit einem Status "success" und den empfangenen Daten
        return response()->json(['status' => 'success', 'data' => $data]);
    }


    /**
     * Gibt die Webhook-Daten für den aktuellen Benutzer zurück.
     *
     * @return JsonResponse
     */
    public function getWebhookData(): JsonResponse
    {
        // Abrufen der aktuellen Benutzer-ID
        $raspUser = RaspUser::getRaspUserId();

        // Abrufen des Benutzers anhand der Benutzer-ID
        $user = User::find($raspUser->user_id);

        // Abrufen der Rolle des RFID-Tags für den Benutzer
        $rfidTagRole = RFID_Tag::where('user_id', $user->id)->first()->role;

        // Protokollieren der ausgehenden Webhook-Daten
        Log::info('Webhook data outgoing: ', [
            'data' => $raspUser->user_id,
            'disruption' => $raspUser->disruption,
            'user_not_found' => $raspUser->user_not_found,
            'service' => $raspUser->service,
            'role' => $rfidTagRole,
        ]);

        // Rückgabe einer JSON-Antwort mit den Webhook-Daten
        return response()->json([
            'data' => $raspUser->user_id,
            'disruption' => $raspUser->disruption,
            'user_not_found' => $raspUser->user_not_found,
            'service' => $raspUser->service,
            'role' => $rfidTagRole,
        ]);
    }


    /**
     * Sendet einen Webhook, um Kaffee basierend auf dem übergebenen Kaffee-Code zu bekommen.
     *
     * @param string $coffeeCode
     * @return int
     */
    public function sendWebhookGetCoffee(string $coffeeCode): int
    {
        Log::info('webhookHandler called' . $coffeeCode);

        $config = $this->getWebhookConfiguration();
        if (!$config) {
            Log::error('Webhook configuration not found.');
            return 500;
        }

        try {
            $client = $this->createGuzzleClient($config['webhook_url'], $coffeeCode);
        } catch (\Exception $e) {
            Log::error('Could not create Guzzle client: ' . $e->getMessage());
            return 500;
        }

        try {
            $response = $this->sendWebhookRequest($client, $config['webhook_url'], $coffeeCode);
            Log::info('Webhook sent to Raspberry Pi: ' . $client->getConfig('action'));
            return $response->getStatusCode();
        } catch (GuzzleException $e) {
            Log::error('Could not send webhook to Raspberry Pi: ' . $e->getMessage());
            return 500;
        }
    }

    /**
     * Returns the webhook configuration.
     *
     * @return array|null
     */
    protected function getWebhookConfiguration(): ?array
    {
        return config('webhook-client.configs.0');
    }

    /**
     * Creates a new Guzzle client with the given webhook URL and coffee code.
     *
     * @param string $webhookUrl
     * @param string $coffeeCode
     * @return Client
     * @throws \Exception
     */
    protected function createGuzzleClient(string $webhookUrl, string $coffeeCode): Client
    {
        return new Client([
            'base_uri' => $webhookUrl,
            'action' => $coffeeCode,
        ]);
    }

    /**
     * Sends the webhook request with the given client, webhook URL, and coffee code.
     *
     * @param Client $client
     * @param string $webhookUrl
     * @param string $coffeeCode
     * @return ResponseInterface
     * @throws GuzzleException
     */
    protected function sendWebhookRequest(Client $client, string $webhookUrl, string $coffeeCode): ResponseInterface
    {
        return $client->post($webhookUrl, [
            'auth' => ['stripe_secret_key', '1'],
            'json' => [
                'url' => $webhookUrl,
                'events' => ['charge.succeeded'],
                'action' => $coffeeCode,
            ],
        ]);
    }



    public static function setId(): Redirector|Application|RedirectResponse
    {
        // Setzen der aktuellen Benutzer-ID auf 0 oder 6, abhängig von der aktuellen Benutzer-ID
        // (benötigt für den klickbaren Buttons auf der Startseite)
        $id = RaspUser::getRaspUserId() == 1 ? 0 : 1;
        RaspUser::setRaspUser($id);

        return redirect('/');
    }
}
