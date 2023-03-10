<?php

namespace Tests\Feature\Integration;

use App\Models\RFID_Tag;
use App\Models\User;
use App\Services\RaspUser;
use App\Services\WebhookService;
use Database\Seeders\TestDatabaseSeeder;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Mockery;
use Monolog\Handler\StreamHandler;
use Tests\TestCase;

class WebHookServiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(TestDatabaseSeeder::class);
    }

    public function test_handle_webhook_returns_success_response()
    {
        $rasp_user_id = 123;
        RaspUser::setRaspUser($rasp_user_id);
        $webhookService = new WebhookService();
        $data = [
            'user_id' => $rasp_user_id,
            'other_data' => 'some_value',
        ];

        $request = Request::create('/test', 'POST', [], [], [], [], json_encode($data));
        $response = $webhookService->handleWebhook($request);

        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->assertEquals($rasp_user_id, $response->getData()->data->user_id);
        $this->assertEquals($data['other_data'], $response->getData()->data->other_data);

    }

    public function test_handle_webhook_sets_rasp_user_id()
    {
        $rasp_user_id = 123;
        $data = [
            'user_id' => $rasp_user_id,
            'other_data' => 'some_value',
        ];
        $request = Request::create('/test', 'POST', [], [], [], [], json_encode($data));
        $webhookService = new WebhookService();

        $webhookService->handleWebhook($request);

        $this->assertEquals($rasp_user_id, RaspUser::getRaspUserId());
    }

    public function test_get_webhook_data_returns_json_response_with_data_and_role()
    {
        $rasp_user_id = 1;
        RaspUser::setRaspUser($rasp_user_id);
        $user = User::find($rasp_user_id);
        $expectedRole = RFID_Tag::find($user->tag_id)->role;

        $response = $this->getJson('/webhook_data');

        $this->assertEquals(Response::HTTP_OK, $response->status());
        $response->assertJson(['data' => $rasp_user_id, 'role' => $expectedRole]);
    }

    public function test_get_webhook_data_returns_404_response_when_rasp_user_id_is_zero()
    {
        RaspUser::setRaspUser(0);

        $response = $this->getJson('/webhook_data');

        $response->assertStatus(500);
    }

    public function test_sendWebhookGetCoffee_with_valid_coffee_code()
    {
        // Arrange
        $coffeeCode = 'coffee';
        config(['webhook-client.configs.0.webhook_url' => 'http://example.com']);
        config(['webhook-client.configs.0.guzzle_http_client' => 'http://example.org']);
        $webhookService = new WebhookService();

        // Act
        $response = $webhookService->sendWebhookGetCoffee($coffeeCode);

        // Assert
        $this->assertEquals(200, $response);
    }
}
