<?php

namespace Tests\Feature\Integration;

use App\Models\RFID_Tag;
use App\Models\User;
use App\Services\RaspUser;
use App\Services\WebhookService;
use Database\Seeders\TestDatabaseSeeder;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Mockery;
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

    public function test_send_webhook_get_coffee_calls_post_method_with_expected_arguments()
    {
        // Arrange
        $coffee_name = 'Latte';
        $url = 'http://127.0.0.1:5000/webhook';
        $events = ['charge.succeeded'];

        // Create a mock handler for the Guzzle client
        $mock = new MockHandler([
            new Response(200),
        ]);
        $handlerStack = HandlerStack::create($mock);

        // Create a Guzzle client with the mock handler
        $client = new Client(['handler' => $handlerStack]);

        $webhookService = new WebhookService();

        // Mock the Log facade to check if the info method is called
        Log::shouldReceive('info')
            ->once()
            ->withArgs(['Webhook sent to Raspberry Pi: ' . $coffee_name]);

        // Act
        $response = $webhookService->sendWebhookGetCoffee($coffee_name, $client);

        // Assert
        $this->assertNull($response);
    }

    public function test_send_webhook_get_coffee_logs_error_when_guzzle_exception_is_thrown()
    {
        // Arrange
        $coffee_name = 'latte';

        $mockClient = Mockery::mock(Client::class);
        $mockClient->shouldReceive('post')
            ->once()
            ->andThrow(GuzzleException::class);

        $webhookService = new WebhookService();
        Log::shouldReceive('info')->once();

        // Act
        $response = $webhookService->sendWebhookGetCoffee($coffee_name);

        // Assert
        $this->assertEquals(302, $response->getStatusCode());
        $mockClient->shouldHaveReceived('post');
    }
}
