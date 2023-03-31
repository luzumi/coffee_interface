<?php

namespace Tests\Feature;

use App\Http\Controllers\RFIDTagController;
use App\Models\RFID_Tag;
use App\Models\User;
use App\Services\RaspUser;
use Database\Seeders\TestDatabaseSeeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RFIDTagTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->seed(TestDatabaseSeeder::class);
    }

    public function test_it_returns_the_correct_rfid_tag()
    {
        $user = User::first();
        RaspUser::setRaspUser($user->id);
        $expectedTag = RFID_Tag::where('user_id', $user->id)->first();

        $controller = new RFIDTagController();

        $tag = $controller->getTag();

        $this->assertEquals($expectedTag->id, $tag->id);
        $this->assertEquals($expectedTag->tag_number, $tag->tag_number);
        $this->assertEquals($expectedTag->role, $tag->role);
        // Add more assertions for other properties as needed
    }

    public function test_rfid_tag_can_be_created()
    {
        $user = User::first();
        $data = [
            'user_id' => $user->id,
            'tag_uid' => '1234567890',
            'role' => 'customer',
            'tag_active' => true,
        ];

        $rfidTag = RFID_Tag::create($data);

        $this->assertDatabaseHas('rfid_tags', $data);
    }

    public function test_rfid_tag_belongs_to_user()
    {
        $rfidTag = RFID_Tag::first();
        $user = $rfidTag->user;

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($user->id, $rfidTag->user_id);
    }

    public function test_rfid_tag_has_many_coffee_orders()
    {
        $rfidTag = RFID_Tag::first();
        $coffeeOrders = $rfidTag->coffeeOrders;

        $this->assertInstanceOf(Collection::class, $coffeeOrders);
        $this->assertCount($coffeeOrders->count(), $coffeeOrders);

        foreach ($coffeeOrders as $coffeeOrder) {
            $this->assertEquals($rfidTag->id, $coffeeOrder->tag_id);
        }
    }

}
