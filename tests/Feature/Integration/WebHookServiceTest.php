<?php

namespace Tests\Feature\Integration;

use App\Models\RFID_Tag;
use App\Models\User;
use App\Services\RaspUser;
use App\Services\WebhookService;
use Database\Seeders\TestDatabaseSeeder;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;



class WebHookServiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->seed(TestDatabaseSeeder::class);
    }

    public function test_handle_webhook_returns_success_response()
    {
        $rasp_user_id = 3;
        RaspUser::setRaspUser($rasp_user_id);
        $rfid_tag = RFID_Tag::where('user_id', $rasp_user_id)->first();
        $webhookService = new WebhookService();
        $data = [
            'tag_uid' => $rfid_tag->tag_uid,
            'other_data' => 'some_value',
        ];

        $request = Request::create('/test', 'POST', [], [], [], [], json_encode($data));
        $response = $webhookService->handleWebhook($request);

        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->assertEquals($rfid_tag->tag_uid, $response->getData()->data->tag_uid);
        $this->assertEquals($data['other_data'], $response->getData()->data->other_data);

    }

    public function test_handle_webhook_sets_rasp_user_id()
    {
        $rasp_user_id = 3;
        RaspUser::setRaspUser($rasp_user_id);
        $rfid_tag = RFID_Tag::where('user_id', $rasp_user_id)->first();
        $webhookService = new WebhookService();
        $data = [
            'tag_uid' => $rfid_tag->tag_uid,
            'other_data' => 'some_value',
        ];
        $request = Request::create('/test', 'POST', [], [], [], [], json_encode($data));
        $webhookService = new WebhookService();

        $webhookService->handleWebhook($request);

        $this->assertEquals($rasp_user_id, RaspUser::getActualRaspUser()->user_id);
    }

    public function test_get_webhook_data_returns_json_response_with_data_and_role()
    {
        $rasp_user_id = 1;
        RaspUser::setRaspUser($rasp_user_id);
        $user = User::find($rasp_user_id);
        $expectedRole = RFID_Tag::where('user_id', $user->id)->first()->role;

        $response = $this->getJson('/webhook_data');

        $this->assertEquals(Response::HTTP_OK, $response->status());
        $response->assertJson(['data' => $rasp_user_id, 'role' => $expectedRole]);
    }
}
