<?php

namespace Tests\Unit;

use App\Models\CoffeeOrder;
use App\Models\RFID_Tag;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Tests\TestCase;

class Rfid_TagTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->seed('TestDatabaseSeeder');
    }

    public function test_rfid_tag_has_user()
    {
        $rfidTag = RFID_Tag::find(1);
        $user = User::find($rfidTag->user->id);

        $this->assertInstanceOf(User::class, $rfidTag->user);
        $this->assertEquals($user->id, $rfidTag->user->id);
    }

    public function test_rfid_tag_has_coffee_orders()
    {
        $rfidTag = RFID_Tag::find(1);

        $this->assertInstanceOf(Collection::class, $rfidTag->coffeeOrders);
        $this->assertInstanceOf(CoffeeOrder::class, $rfidTag->coffeeOrders->first());
    }

    public function test_rfid_tag_can_be_created()
    {
        $user = User::create([
            'username' => 'new_user',
            'firstname' => 'Test',
            'lastname' => 'Unit',
            'credits' => 0,
            'active' => true,
            'remarks' => '',
        ]);

        $data = [
            'user_id' => $user->id,
            'tag_uid' => '1234567890',
            'role' => 'customer',
            'tag_active' => true,
        ];

        $rfidTag = RFID_Tag::create($data);

        $this->assertDatabaseHas('users', [
            'username' => 'new_user',
            'firstname' => 'Test',
            'lastname' => 'Unit',
        ]);
        $this->assertDatabaseHas('rfid_tags', $data);
    }


    public function test_rfid_tag_cannot_be_created_without_required_fields()
    {
        $data = [
            // missing required fields
        ];

        $this->expectException(QueryException::class);
        RFID_Tag::create($data);
    }

    public function test_rfid_tag_can_be_updated()
    {
        $rfidTag = RFID_Tag::find(1);
        $newData = [
            'role' => 'admin',
        ];

        $rfidTag->update($newData);

        $this->assertDatabaseHas('rfid_tags', $newData);
    }

    public function test_rfid_tag_can_be_deleted()
    {
        $rfidTag = RFID_Tag::find(1);

        // Delete any related User instances that reference this RFID_Tag
        if ($rfidTag->users !== null) {
            foreach ($rfidTag->users as $user) {
                $user->update(['tag_id' => null]);
            }
        }

        // Delete any related CoffeeOrder instances that reference this RFID_Tag
        foreach ($rfidTag->coffeeOrders as $coffeeOrder) {
            $coffeeOrder->delete();
        }

        // Delete the RFID_Tag instance
        $rfidTag->delete();

        $this->assertDatabaseMissing('rfid_tags', ['id' => 1]);
    }

}
