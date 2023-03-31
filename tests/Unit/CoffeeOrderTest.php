<?php

namespace Tests\Unit;

use Database\Seeders\TestDatabaseSeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\CoffeeOrder;
use App\Models\RFID_Tag;
use App\Models\User;
use App\Models\CoffeeVariety;

class CoffeeOrderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->seed(TestDatabaseSeeder::class);
    }

    public function test_coffee_order_belongs_to_rfid_tag()
    {
        $rfidTag = RFID_Tag::find(1);
        $coffeeOrder = CoffeeOrder::find(1);

        $this->assertInstanceOf(RFID_Tag::class, $coffeeOrder->rfidTag);
        $this->assertEquals($rfidTag->id, $coffeeOrder->rfidTag->id);
    }

    public function test_coffee_order_belongs_to_user()
    {
        $coffeeOrder = CoffeeOrder::find(1);
        $user = User::find($coffeeOrder->user->id);

        $this->assertInstanceOf(User::class, $coffeeOrder->user);
        $this->assertEquals($user->id, $coffeeOrder->user->id);
    }

    public function test_coffee_order_belongs_to_coffee_variety()
    {
        $coffeeOrder = CoffeeOrder::find(1);
        $coffeeVarieties = CoffeeVariety::find($coffeeOrder->coffeeVariety->id);

        $this->assertEquals($coffeeVarieties->id, $coffeeOrder->coffeeVariety->id);
        $this->assertInstanceOf(CoffeeVariety::class, $coffeeOrder->coffeeVariety);
    }

    public function test_coffee_order_can_be_created()
    {
        $data = [
            'tag_id' => 1,
            'user_id' => 1,
            'coffee_name' => 'Espresso',
        ];

        $coffeeOrder = CoffeeOrder::create($data);

        $this->assertDatabaseHas('coffee_orders', $data);
    }

    public function test_coffee_order_cannot_be_created_without_required_fields()
    {
        $data = [
            // missing required fields
        ];

        $this->expectException(QueryException::class);
        CoffeeOrder::create($data);
    }

    public function test_coffee_order_can_be_deleted()
    {
        $coffeeOrder = CoffeeOrder::find(1);
        $coffeeOrder->delete();

        $this->assertDatabaseMissing('coffee_orders', ['id' => 1]);
    }

    public function test_coffee_order_has_coffee_variety()
    {
        $coffeeOrder = CoffeeOrder::find(1);

        $this->assertInstanceOf(CoffeeVariety::class, $coffeeOrder->coffeeVariety);
    }

}
