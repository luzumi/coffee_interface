<?php

namespace App\Services;

use App\Models\RFID_Tag;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;

class WebhookService
{
    /**
     * Verarbeitet den empfangenen Webhook und speichert den Benutzer entsprechend.
     * Die Daten werden aus dem RaspUser-Objekt und der RFID-Karte des
     * Benutzers entnommen, werden zusätzlich in die Log-Datei geschrieben
     * und an den Webhook-Server zurückgegeben.
     *
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     */
    public function handleWebhook(Request $request): View
                                                    | Factory
                                                    | JsonResponse
                                                    | Application
    {
        $data = $request->json()->all();

        $rfidTag = RFIDService::getRFIDTag($data['tag_uid']);
        $userId = $rfidTag->user->id;

        Log::info('Webhook data incoming: ', $data);

        $disruption = $data['disruption'] ?? false;
        $service = $data['need_service'] ?? false;

        RaspUser::setRaspUser($userId,
            $disruption,
            $service,
            false,
            $data['tag_uid'],
        );

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Gibt die Webhook-Daten für den aktuellen Benutzer zurück.
     * Die Daten werden aus dem RaspUser-Objekt und der RFID-Karte
     * des Benutzers entnommen, werden zusätzlich in die Log-Datei
     * geschrieben und anschließend als JSON-Objekt zurückgegeben.
     * Wenn der Benutzer nicht gefunden wurde, wird eine
     * entsprechende Response zurückgegeben.
     *
     * @return JsonResponse|null
     */
    public function getWebhookData(): ?JsonResponse
    {
        Log::info('getWebhookData called'); // Debug-Statement hinzugefügt

        $raspUser = RaspUser::getActualRaspUser();
        if ($raspUser->user_id < 1) {
            $defaultResponse = response()->json([
                'data' => $raspUser->user_id,
                'disruption' => false,
                'user_not_found' => true,
                'need_service' => false,
                'role' => 'user_not_found',
                'tag_uid' => $raspUser->rfid_tag,
            ]);

            Log::info('getWebhookData: Default response', [
                'response' => $defaultResponse
            ]);

            return $defaultResponse;
        }

        if ($raspUser->user_not_found) {
            return $this->responseUserNotFound($raspUser->user_id);
        }

        $user = User::find($raspUser->user_id);
        $rfidTagRole = RFID_Tag::where('user_id', $user->id)
            ->first()
            ->role;

        return $this->createWebhookDataResponse($raspUser, $rfidTagRole);
    }

    /**
     * Erstellt eine Response mit den Webhook-Daten für einen
     * neuen Benutzer, bei dem die RFID-Karte noch unbekannt ist.
     * Die Daten werden aus dem RaspUser-Objekt entnommen,
     * werden zusätzlich in die Log-Datei geschrieben und
     * anschließend als JSON-Objekt zurückgegeben.
     *
     * @param int $userId
     * @return JsonResponse
     */
    private function responseUserNotFound(int $userId): JsonResponse
    {
        return response()->json([
            'data' => $userId,
            'disruption' => false,
            'user_not_found' => true,
            'need_service' => false,
            'role' => 'user_not_found',
        ]);
    }

    /**
     * Erstellt eine Response mit den Webhook-Daten für den aktuellen Benutzer.
     * Die Daten werden aus dem RaspUser-Objekt und der RFID-Karte
     * des Benutzers entnommen, werden zusätzlich in die Log-Datei geschrieben
     * und anschließend als JSON-Objekt zurückgegeben.
     *
     * @param $raspUser
     * @param string $rfidTagRole
     * @return JsonResponse
     */
    private function createWebhookDataResponse($raspUser,
                                               string $rfidTagRole): JsonResponse
    {
        $responseText = [
            'data' => $raspUser->user_id,
            'disruption' => $raspUser->disruption,
            'user_not_found' => $raspUser->user_not_found,
            'need_service' => $raspUser->need_service,
            'role' => $rfidTagRole,
        ];

        Log::info('Webhook data outgoing: ', $responseText);

        return response()->json($responseText);
    }


    /**
     * Sendet einen Webhook, um Kaffee basierend auf dem übergebenen
     * Kaffee-Code zu bekommen. Der Webhook wird an den Raspberry Pi
     * gesendet, der den Kaffee ausgibt. Der Webhook wird nur gesendet,
     * wenn die Konfiguration für den Webhook vorhanden ist.
     *
     * @param string $coffeeCode
     * @return int
     * @throws GuzzleException
     * @throws Exception
     */
    public function sendWebhookGetCoffee(string $coffeeCode): int
    {
        Log::info('webhookHandler called' . $coffeeCode);

        $config = $this->getWebhookConfiguration();

        if (!$config) {
            Log::error('Webhook configuration not found.');
            return 500;
        }

        $client = $this->createGuzzleClient(
            $config['webhook_url'],
            $coffeeCode);

        if (!$client) {
            Log::error('Could not create Guzzle client.');
            return 500;
        }

        $response = $this->sendWebhookRequest($client,
            $config['webhook_url'],
            $coffeeCode);

        if (!$response) {

            Log::error('Could not send webhook to Raspberry Pi.');
            return 500;
        }

        Log::info('Webhook sent to Raspberry Pi: ' . $coffeeCode);

        return $response->getStatusCode();
    }

    /**
     * Gibt die Konfiguration für den Webhook zurück.
     * Die Konfiguration wird aus der .env-Datei entnommen.
     * Wenn die Konfiguration nicht vorhanden ist, wird null zurückgegeben.
     * Wenn die Konfiguration nicht vollständig ist,
     * wird eine Exception geworfen.
     *
     * @param string $webhookUrl = env('WEBHOOK_URL')
     * @param string $coffeeCode
     * @return Client|null
     */
    private function createGuzzleClient(string $webhookUrl,
                                        string $coffeeCode): ?Client
    {
        try {
            return new Client([
                'base_uri' => $webhookUrl,
                'action' => $coffeeCode,
            ]);
        } catch (Exception $e) {
            Log::error('Could not create Guzzle client: '
                . $e->getMessage());
            return null;
        }
    }

    /**
     * Sendet einen Webhook an den Raspberry Pi.
     * Gibt die Response zurück, wenn erfolgreich, sonst null.
     * Bei einem Fehler wird eine Exception geworfen.
     *
     * @param $client
     * @param $webhookUrl = env('WEBHOOK_URL')
     * @param string $coffeeCode
     * @return mixed|null
     * @throws GuzzleException wird geworfen, wenn der Webhook
     * nicht gesendet werden konnte
     */
    private function sendWebhookRequest($client,
                                        $webhookUrl,
                                        string $coffeeCode): mixed
    {
        try {
            return $client->post($webhookUrl, [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => ['action' => $coffeeCode],
            ]);
        } catch (GuzzleException $e) {
            Log::error('Could not send webhook to Raspberry Pi: '
                . $e->getMessage());
            return null;
        }
    }

    /**
     * Gibt die Webhook-Konfiguration zurück.
     * Die Konfiguration wird aus der .env-Datei entnommen.
     * Wenn die Konfiguration nicht vorhanden ist, wird null zurückgegeben.
     *
     * @return array|null
     */
    protected function getWebhookConfiguration(): ?array
    {
        return config('webhook-client.configs.0');
    }

    /**
     * Setzt die aktuelle Benutzer-ID auf 0 oder 6, abhängig von der
     * aktuellen Benutzer-ID.  Benötigt für den klickbaren Buttons
     * auf der Startseite. (für Production-Mode nicht benötigt)
     *
     * @return Redirector|Application|RedirectResponse
     */
    public static function setId(): Redirector|Application|RedirectResponse
    {
        $id = RaspUser::getActualRaspUser()->user_id == 8 ? 0 : 8;
        Log::info('Set ID to ' . $id);
        RaspUser::setRaspUser($id, RaspUser::getActualRaspUser()->rfid_tag);

        return redirect('/');
    }
}
