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

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed('TestDatabaseSeeder');
    }

    public function test_user_has_rfid_tag()
    {
        $user = User::find(1);
        $rfidTag = RFID_Tag::find($user->tag_id);

        $this->assertInstanceOf(RFID_Tag::class, $user->rfidTag);
        $this->assertEquals($rfidTag->id, $user->rfidTag->id);
    }

    public function test_user_has_coffee_orders()
    {
        $user = User::find(1);

        $this->assertInstanceOf(Collection::class, $user->coffeeOrders);
        $this->assertInstanceOf(CoffeeOrder::class, $user->coffeeOrders->first());
    }

    public function test_user_can_be_created()
    {
        $data = [
            'username' => 'new_user',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'tag_id' => 2,
            'credits' => 0,
            'active' => true,
            'remarks' => '',
        ];

        $user = User::create($data);

        $this->assertDatabaseHas('users', $data);
    }

    public function test_user_cannot_be_created_without_required_fields()
    {
        $data = [
            // missing required fields
        ];

        $this->expectException(QueryException::class);
        User::create($data);
    }

    public function test_user_can_be_updated()
    {
        $user = User::find(1);
        $newData = [
            'username' => 'new_username',
        ];

        $user->update($newData);

        $this->assertDatabaseHas('users', $newData);
    }

    public function test_user_can_be_deleted()
    {
        $user = User::find(1);

        // Lösche zuerst alle CoffeeOrders, die mit dem User verknüpft sind
        foreach ($user->coffeeOrders as $coffeeOrder) {
            $coffeeOrder->delete();
        }

        // Lösche dann den User
        $user->delete();

        $this->assertDatabaseMissing('users', ['id' => 1]);
    }
}
